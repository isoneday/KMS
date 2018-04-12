<?php

$sql["count_notificationtemplate"] = "
SELECT FOUND_ROWS() AS total
";
$sql["get_notificationtemplate"] = "
SELECT SQL_CALC_FOUND_ROWS
    a.notiftmpl_id AS `id`,
    a.notiftmpl_purpose AS `purpose`,
    a.notiftmpl_subject AS `subject`,
    a.notiftmpl_param AS `param`,
    a.notiftmpl_url AS `url`,
    a.notiftmpl_status AS `status`,
    a.notiftmpl_desc AS `desc`,
    a.notiftmpl_is_locked AS `is_locked`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    a.unit_id AS `unit_id`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM comp_notification_template a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_notificationtemplate"] = "
SELECT 
    a.notiftmpl_id AS `id`,
    a.notiftmpl_purpose AS `purpose`,
    a.notiftmpl_subject AS `subject`,
    a.notiftmpl_param AS `param`,
    a.notiftmpl_url AS `url_notif`,
    a.notiftmpl_status AS `status`,
    a.notiftmpl_desc AS `desc`,
    a.notiftmpl_is_locked AS `is_locked`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    a.unit_id AS `unit_id`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM comp_notification_template a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE notiftmpl_id = %d
";
$sql["get_detail_notificationtemplate_body"] = "
SELECT
	l.`lang_code` AS `code`,
	t.`notiftmpltext_body` AS `text`
FROM
    (SELECT %d AS notiftmpl_id) r
LEFT JOIN gtfw_lang AS l ON 1 = 1
LEFT JOIN comp_notification_template_text AS t ON t.`notiftmpltext_notiftmpl_id` = r.notiftmpl_id AND l.lang_code = t.`notiftmpltext_lang_code`
";
$sql["get_detail_notificationtemplate_altbody"] = "
SELECT
	l.`lang_code` AS `code`,
	t.`notiftmpltext_altbody` AS `text`
FROM
    (SELECT %d AS notiftmpl_id) r
LEFT JOIN gtfw_lang AS l ON 1 = 1
LEFT JOIN comp_notification_template_text AS t ON t.`notiftmpltext_notiftmpl_id` = r.notiftmpl_id AND l.lang_code = t.`notiftmpltext_lang_code`
";
$sql["insert_notificationtemplate"] = "
INSERT INTO comp_notification_template
(
    notiftmpl_purpose,
    notiftmpl_subject,
    notiftmpl_param,
    notiftmpl_url,
    notiftmpl_status,
    notiftmpl_desc,
    notiftmpl_is_locked,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    NOW()
)
";
$sql['insert_notificationtemplate_text'] = "
INSERT INTO `comp_notification_template_text`(
     `notiftmpltext_notiftmpl_id`,
     `notiftmpltext_lang_code`,
     `notiftmpltext_body`,
     `notiftmpltext_altbody`,
     `insert_user_id`,
     `insert_timestamp`
)VALUES (
        %s,
        %s,
        %s,
        %s,
        %s,
        NOW()
)    
";
$sql["update_notificationtemplate"] = "
UPDATE comp_notification_template
SET 
    notiftmpl_purpose = %s,
    notiftmpl_subject = %s,
    notiftmpl_param = %s,
    notiftmpl_url = %s,
    notiftmpl_status = %s,
    notiftmpl_desc = %s,
    notiftmpl_is_locked = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE notiftmpl_id = %d
";
$sql["delete_notificationtemplate"] = "
DELETE FROM comp_notification_template
WHERE notiftmpl_id = %d
";
$sql['delete_notificationtemplate_text'] = "
DELETE
FROM `comp_notification_template_text`
WHERE `notiftmpltext_notiftmpl_id` = '%s'  
";