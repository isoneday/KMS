<?php

$sql['get_default_lang'] = "
SELECT
  `setting_id` AS `id`,
  `setting_name` AS `name`,
  `setting_value` AS `value`
FROM `gtfw_setting`
WHERE setting_name = %d    
";
$sql['get_old_notification'] = "
SELECT
   notif_title,
   notif_content,
   notif_duration,
   notif_url
FROM
   comp_notification_content c
   JOIN comp_notification_user u USING (notif_id)
WHERE
   u.notif_user_id = %s AND
   u.notif_is_read = 1 AND
   DATEDIFF(NOW(),c.insert_timestamp) < 5
ORDER BY
   c.insert_timestamp DESC
LIMIT 5
";

$sql['get_notification'] = "
SELECT SQL_CALC_FOUND_ROWS
   notif_title,
   notif_content,
   notif_duration,
   notif_url,
   c.insert_timestamp
FROM
   comp_notification_content c
   JOIN comp_notification_user u USING (notif_id)
WHERE
   u.notif_user_id = %s AND
   DATEDIFF(NOW(),c.insert_timestamp) < 90
   --filter--
ORDER BY
   c.insert_timestamp DESC
LIMIT %s, %s
";

$sql['get_unread_notification'] = "
SELECT
   notif_title,
   notif_content,
   notif_duration,
   notif_url
FROM
   comp_notification_content c
   JOIN comp_notification_user u USING (notif_id)
WHERE
   u.notif_user_id = %s AND
   u.notif_is_read = 0
ORDER BY
   c.insert_timestamp
";

$sql['set_read'] = "
UPDATE
   comp_notification_user
SET
   notif_is_read = 1,
   update_user_id = insert_user_id,
   update_timestamp = NOW()
WHERE
   notif_user_id = %s AND
   notif_is_read = 0
";

$sql['add_notification_control'] = "
INSERT INTO
   comp_notification_user
   (
      notif_id,
      notif_user_id,
      notif_is_read,
      insert_user_id,
      insert_timestamp,
      update_user_id,
      update_timestamp
   )
SELECT
   %s,
   user_id,
   0,
   param_user_id,
   NOW(),
   param_user_id,
   NOW()
FROM
   (SELECT %s as param_user_id) param
   JOIN gtfw_user ON true
WHERE
   user_id IN (--ID-LIST--)
";

$sql['add_notification_content'] = "
INSERT INTO
   comp_notification_content
   (
      notif_title,
      notif_content,
      notif_duration,
      notif_url,
      insert_user_id,
      insert_timestamp,
      update_timestamp
   )
VALUES
(
   %s,
   %s,
   %s,
   %s,
   %s,
   NOW(),
   NOW()
)
";

$sql['get_user_id_by_group_id'] = "
SELECT
   usergroup_user_id
FROM
   gtfw_user_group
WHERE
   usergroup_group_id IN (--ID-LIST--)
";
$sql['get_template_notification_detail'] = "
SELECT
  a.`notiftmpltext_notiftmpl_id` AS id,
  a.`notiftmpltext_lang_code` AS lang_code,
  a.`notiftmpltext_body` AS body,
  a.`notiftmpltext_altbody` AS alt_body,
  b.`notiftmpl_url` AS url,
  b.`notiftmpl_subject` AS `subject`
FROM `comp_notification_template_text` a
LEFT JOIN comp_notification_template b ON b.`notiftmpl_id` = a.`notiftmpltext_notiftmpl_id`
WHERE
b.`notiftmpl_purpose` = '%s'
AND a.notiftmpltext_lang_code = '%s'    
";