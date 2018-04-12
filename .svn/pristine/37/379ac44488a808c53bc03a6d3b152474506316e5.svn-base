<?php

$sql["count_smstemplate"] = "
SELECT FOUND_ROWS() AS total
";
$sql["get_smstemplate"] = "
SELECT SQL_CALC_FOUND_ROWS
    a.smstmpl_id AS `id`,
    a.smstmpl_purpose AS `purpose`,
    a.smstmpl_subject AS `subject`,
    a.smstmpl_param AS `param`,
    a.smstmpl_url AS `url_notif`,
    a.smstmpl_status AS `status`,
    a.smstmpl_desc AS `desc`,
    a.smstmpl_is_locked AS `is_locked`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    a.unit_id AS `unit_id`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM comp_sms_template a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_smstemplate"] = "
SELECT 
    a.smstmpl_id AS `id`,
    a.smstmpl_purpose AS `purpose`,
    a.smstmpl_subject AS `subject`,
    a.smstmpl_param AS `param`,
    a.smstmpl_url AS `url_notif`,
    a.smstmpl_status AS `status`,
    a.smstmpl_desc AS `desc`,
    a.smstmpl_is_locked AS `is_locked`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    a.unit_id AS `unit_id`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM comp_sms_template a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE smstmpl_id = %d
";
$sql["get_detail_smstemplate_body"] = "
SELECT
	l.`lang_code` AS `code`,
	t.`smstmpltext_body` AS `text`
FROM
    (SELECT %d AS smstmpl_id) r
LEFT JOIN gtfw_lang AS l ON 1 = 1
LEFT JOIN comp_sms_template_text AS t ON t.`smstmpltext_smstmpl_id` = r.smstmpl_id AND l.lang_code = t.`smstmpltext_lang_code`
";
$sql["insert_smstemplate"] = "
INSERT INTO comp_sms_template
(
    smstmpl_purpose,
    smstmpl_subject,
    smstmpl_param,
    smstmpl_url,
    smstmpl_status,
    smstmpl_desc,
    smstmpl_is_locked,
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
$sql['insert_smstemplate_text'] = "
INSERT INTO `comp_sms_template_text`(
      smstmpltext_smstmpl_id,
     `smstmpltext_lang_code`,
     `smstmpltext_body`,
     `insert_user_id`,
     `insert_timestamp`
)VALUES (
        '%s',
        '%s',
        '%s',
        '%s',
        NOW()
)    
";
$sql["update_smstemplate"] = "
UPDATE comp_sms_template
SET 
    smstmpl_purpose = %s,
    smstmpl_subject = %s,
    smstmpl_param = %s,
    smstmpl_url = %s,
    smstmpl_status = %s,
    smstmpl_desc = %s,
    smstmpl_is_locked = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE smstmpl_id = %d
";
$sql["delete_smstemplate"] = "
DELETE FROM comp_sms_template
WHERE smstmpl_id = %d
";
$sql['delete_smstemplate_text'] = "
DELETE
FROM `comp_sms_template_text`
WHERE `smstmpltext_smstmpl_id` = '%s'    
";