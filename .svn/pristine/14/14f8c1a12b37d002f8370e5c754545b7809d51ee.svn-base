<?php

$sql['list_folder'] = "
SELECT
   folder_id,
   folder_name,
   COUNT(ctrl_id) AS msg_count
FROM
   (SELECT %d AS user_id) param
   JOIN comp_message_folder ON folder_owner_id = user_id OR folder_owner_id IS NULL
   LEFT JOIN comp_message_control ON ctrl_folder_id = folder_id AND ctrl_user_id = user_id
GROUP BY
   folder_id
ORDER BY
   IF(folder_owner_id IS NULL, 0, 1),
   IF(folder_owner_id IS NULL, folder_id, folder_name)
";

$sql['list_message'] = "
SELECT SQL_CALC_FOUND_ROWS
   msg_id,
   msg_subject,
   msg_owner_id,
   c.update_timestamp,
   user_real_name AS SenderRealName,
   IFNULL(user_user_name,msg_owner_name) AS SenderUserName,
   ctrl_id,
   ctrl_type,
   ctrl_folder_id,
   ctrl_sent_date,
   ctrl_read_date,
   ctrl_is_read
FROM
   (SELECT %d AS folder_id, %d AS usr_id) AS param
   JOIN comp_message_control c ON c.ctrl_folder_id = folder_id AND c.ctrl_user_id = usr_id
   JOIN comp_message_content m ON msg_id = ctrl_msg_id
   LEFT JOIN gtfw_user ON user_id = msg_owner_id
   LEFT JOIN comp_message_blacklist ON blacklist_owner_id= usr_id AND blacklist_user_id = msg_owner_id
WHERE
   blacklist_user_id IS NULL
ORDER BY
   IF(ctrl_type = 'in' && ctrl_is_read = 0, 0, 1),
   c.update_timestamp DESC
LIMIT %d, %d
";

$sql['count_new_message'] = "
SELECT
   COUNT(ctrl_id) AS total
FROM
   comp_message_control
WHERE
   ctrl_user_id = %s AND
   ctrl_is_read = 0 AND
   ctrl_folder_id = 1
";

$sql['get_message_to_read'] = "
SELECT
   ctrl_msg_id,
   ctrl_is_read
FROM
   comp_message_control
WHERE
   ctrl_id = %s AND
   ctrl_user_id = %s
";

$sql['get_message_detail'] = "
SELECT
   msg_id,
   msg_owner_id,
   msg_subject,
   msg_content,
   msg_in_reply_to,
   c.insert_timestamp,
   c.update_timestamp,
   user_real_name AS SenderRealName,
   IFNULL(user_user_name,msg_owner_name) AS SenderUserName,
   ctrl_id,
   ctrl_type,
   ctrl_folder_id,
   ctrl_sent_date,
   ctrl_read_date,
   ctrl_is_read,
   folder_id,
   folder_name
FROM
   (SELECT %d AS msgId, %d AS userId) AS param
   JOIN comp_message_content c ON c.msg_id = msgId
   LEFT JOIN gtfw_user ON user_id = msg_owner_id
   LEFT JOIN comp_message_control ON ctrl_msg_id = msg_id AND ctrl_user_id = userId
   LEFT JOIN comp_message_folder ON folder_id = ctrl_folder_id
WHERE
   userId IS NULL OR userId = msg_owner_id OR ctrl_id IS NOT NULL
";

$sql['get_user_list'] = "
SELECT
  user_id,
  user_user_name,
  user_real_name,
-- 	e.emp_name,
-- 	eu.empuser_emp_id,
-- 	eun.empunit_id,
-- 	eun.empunit_start,
-- 	eun.empunit_end,
	eun.empunit_unit_id AS unit_id
FROM
   (SELECT %s userId) AS param
JOIN gtfw_user ON user_id != userId AND user_id > 1
LEFT JOIN comp_message_blacklist ON blacklist_owner_id = userId AND blacklist_user_id = user_id
LEFT JOIN emp_employee_user eu ON eu.empuser_user_id = user_id
-- LEFT JOIN emp_employee e ON e.emp_id = eu.empuser_emp_id
LEFT JOIN emp_employee_unit eun ON eun.empunit_emp_id = eu.empuser_emp_id AND CURRENT_DATE() BETWEEN eun.empunit_start AND eun.empunit_end
WHERE
   blacklist_user_id IS NULL
GROUP BY
   user_id
ORDER BY
   IF(user_real_name = '', user_user_name, user_real_name)
";

$sql['get_recipient_list'] = "
SELECT
   user_id,
   user_real_name,
   IFNULL(user_user_name,ctrl_user_name) AS UserName,
   ctrl_id,
   ctrl_msg_id as msgId,
   ctrl_folder_id,
   ctrl_sent_date,
   ctrl_read_date,
   ctrl_is_read
FROM
   comp_message_control
   LEFT JOIN gtfw_user ON user_id = ctrl_user_id
WHERE
   ctrl_msg_id IN ('%s') AND
   ctrl_type = 'in'
";

$sql['control_delete_recipient'] = "
DELETE FROM
   comp_message_control
WHERE
   ctrl_id IN ('%s')
";

$sql['save_message_content'] = "
INSERT INTO
   comp_message_content
   (
      msg_id,
      msg_owner_id,
      msg_owner_name,
      msg_subject,
      msg_content,
      msg_in_reply_to,
      insert_timestamp,
      update_timestamp
   )
SELECT
   %s,
   user_id,
   user_user_name,
   %s,
   %s,
   %s,
   NOW(),
   NOW()
FROM
   gtfw_user
WHERE
   user_id = %s
ON DUPLICATE KEY UPDATE
   msg_subject = VALUES(msg_subject),
   msg_content = VALUES(msg_content),
   update_timestamp = VALUES(update_timestamp)
";

$sql['control_add_sender'] = "
INSERT INTO
   comp_message_control
   (
      ctrl_msg_id,
      ctrl_user_id,
      ctrl_user_name,
      ctrl_type,
      ctrl_folder_id,
      ctrl_is_read,
      insert_timestamp,
      update_timestamp
   )
SELECT
   %s,
   user_id,
   user_user_name,
   'draft',
   '3',
   1,
   NOW(),
   NOW()
FROM
   gtfw_user
WHERE
   user_id = %s
";

$sql['control_add_recipient'] = "
INSERT INTO
   comp_message_control
   (
      ctrl_msg_id,
      ctrl_user_id,
      ctrl_user_name,
      ctrl_type,
      ctrl_folder_id,
      ctrl_is_read,
      insert_timestamp,
      update_timestamp
   )
SELECT
   %s,
   user_id,
   user_user_name,
   'in',
   NULL,
   0,
   NOW(),
   NOW()
FROM
   gtfw_user
WHERE
   user_id IN (--IDLIST--)
";

$sql['control_send'] = "
UPDATE
   comp_message_control
SET
   ctrl_type = IF(ctrl_type = 'draft','out','in'),
   ctrl_folder_id = IF(ctrl_type = 'in',1,IF(ctrl_folder_id = 3,2,ctrl_folder_id)),
   ctrl_sent_date = NOW(),
   update_timestamp = NOW()
WHERE
   ctrl_msg_id = %s
";

$sql['control_set_read'] = "
UPDATE
    comp_message_control
SET
   ctrl_is_read = 1,
   ctrl_read_date = IF(ctrl_read_date = '0000-00-00 00:00:00',NOW(),ctrl_read_date)
WHERE
   ctrl_id = %s
";
$sql['control_delete_recipient'] = "
DELETE FROM
   pub_message_control
WHERE
   ctrlId IN ('%s')
";

$sql['control_unlink'] = "
UPDATE
   comp_message_control
SET
   ctrl_folder_id = NULL
WHERE
   ctrl_id IN (%s) AND
   ctrl_user_id = %s
";

$sql['control_unread'] = "
UPDATE
   comp_message_control
SET
   ctrlIsRead = 0
WHERE
   ctrl_id IN (%s) AND
   ctrl_user_id = %s
";

$sql['control_move'] = "
UPDATE
   (SELECT %s AS folderId) param,
   comp_message_control
SET
   ctrl_folder_id = IF((folderId = 1 AND ctrl_type = 'in') OR (folderId = 2 AND ctrl_type = 'out') OR (folderId = 3 AND ctrl_type = 'draft') OR folderId > 3,folderId,ctrl_folder_id)
WHERE
   ctrl_id IN (%s) AND
   ctrl_user_id = %s
";

$sql['get_folder_list'] = "
SELECT
   folder_id,
   folder_name,
   COUNT(ctrl_id) AS msgCount
FROM
   (SELECT %d AS userId) param
   JOIN comp_message_folder ON folder_owner_id = userId OR folder_owner_id IS NULL
   LEFT JOIN comp_message_control ON ctrl_folder_id = folder_id AND ctrl_user_id = userId
GROUP BY
   folder_id
ORDER BY
   IF(folder_owner_id IS NULL, 0, 1),
   IF(folder_owner_id IS NULL, folder_id, folder_name)
";

$sql['get_black_list'] = "
SELECT
   user_id,
   user_user_name,
   user_real_name
FROM
   (SELECT '%s' paramUserId) AS param
   JOIN gtfw_user ON user_id != paramUserId AND user_id > 1
   JOIN comp_message_blacklist ON blacklist_owner_id = paramUserId AND blacklist_user_id = user_id
ORDER BY
   IF(user_real_name = '', user_user_name, user_real_name)
";

$sql['get_all_user'] = "
SELECT
   user_id,
   user_user_name,
   user_real_name
FROM
   gtfw_user
WHERE
   user_id > 1 AND user_id != %s
ORDER BY
   IF(user_real_name = '', user_user_name, user_real_name)
";

$sql['folder_add'] = "
INSERT INTO
   comp_message_folder
   (
      folder_name,
      folder_owner_id,
      folder_Owner_name,
      insert_timestamp,
      update_timestamp
   )
SELECT
   %s,
   user_id,
   user_user_name,
   NOW(),
   NOW()
FROM
   gtfw_user
WHERE
   user_id = %s
";

$sql['folder_edit'] = "
UPDATE
   comp_message_folder
SET
   folder_name = %s,
   update_timestamp = NOW()
WHERE
   folder_id = %s AND
   folder_owner_id = %s
";

$sql['folder_unlink'] = "
UPDATE
   comp_message_control
SET
   ctrl_folder_id = null,
   update_timestamp = NOW()
WHERE
   ctrl_folder_id = %s AND
   ctrl_user_id = %s
";

$sql['folder_delete'] = "
DELETE FROM
   comp_message_folder
WHERE
   folder_id = %s AND
   folder_owner_id = %s
";

$sql['blacklist_add'] = "
INSERT INTO
   comp_message_blacklist
   (
      blacklist_owner_id,
      blacklist_owner_name,
      blacklist_user_id,
      blacklist_user_name,
      insert_timestamp,
      update_timestamp
   )
SELECT
   owner.user_id,
   owner.user_user_name,
   target.user_id,
   target.user_user_name,
   NOW(),
   NOW()
FROM
   gtfw_user owner,
   gtfw_user target
WHERE
   target.user_id IN (%s) AND
   owner.user_id = %s
";

$sql['blacklist_del'] = "
DELETE FROM
   comp_message_blacklist
WHERE
   blacklist_user_id IN (%s) AND
   blacklist_owner_id = %s
";

$sql['get_message_detail_for_email'] = "
SELECT
   msg_subject,
   msg_content,
   c.update_timestamp,
   IF(sender1.user_real_name = '',sender1.user_user_name,sender1.user_real_name) AS senderName,
   sender1.user_email AS senderEmail,
   IF(receiver1.user_real_name = '',receiver1.user_user_name,receiver1.user_real_name) AS receiverName,
   receiver1.user_email AS receiverEmail
FROM
   comp_message_control c
   JOIN comp_message_content ON msg_id = ctrl_msg_id
   LEFT JOIN gtfw_user sender1 ON sender1.user_id = msg_owner_id
   LEFT JOIN gtfw_user receiver1 ON receiver1.user_id = ctrl_user_id
WHERE
   ctrl_id IN ('%s') AND
   ctrl_user_id = %s
GROUP BY
   ctrl_id
";

$sql['get_unit_list'] = "
SELECT 
	unit_id AS id,
	unit_name AS `name`
FROM `gtfw_unit`
ORDER BY unit_level
";
