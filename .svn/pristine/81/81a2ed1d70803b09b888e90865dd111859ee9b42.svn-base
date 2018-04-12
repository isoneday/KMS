<?php

$sql["count_emailtemplate"] = "
SELECT FOUND_ROWS() AS total
";
$sql["get_emailtemplate"] = "
SELECT SQL_CALC_FOUND_ROWS
    a.emailtmpl_id AS `id`,
    a.emailtmpl_purpose AS `purpose`,
    a.emailtmpl_subject AS `subject`,
    a.emailtmpl_from AS `from`,
    a.emailtmpl_from_name AS `from_name`,
    a.emailtmpl_body AS `body`,
    a.emailtmpl_altbody AS `altbody`,
    a.emailtmpl_attachment AS `attachment`,
    a.emailtmpl_param AS `param`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    a.unit_id AS `unit_id`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM comp_email_template a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_emailtemplate"] = "
SELECT 
    a.emailtmpl_id AS `id`,
    a.emailtmpl_purpose AS `purpose`,
    a.emailtmpl_subject AS `subject`,
    a.emailtmpl_from AS `from`,
    a.emailtmpl_from_name AS `from_name`,
    a.emailtmpl_body AS `body`,
    a.emailtmpl_altbody AS `altbody`,
    a.emailtmpl_attachment AS `attachment`,
    a.emailtmpl_param AS `param`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    a.unit_id AS `unit_id`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM comp_email_template a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE emailtmpl_id = %d
";
$sql["get_detail_emailtemplate_body"] = "
SELECT
	l.`lang_code` AS `code`,
	t.`emailtmpltext_body` AS `text`
FROM
    (SELECT %d AS emailtmpl_id) r
LEFT JOIN gtfw_lang AS l ON 1 = 1
LEFT JOIN comp_email_template_text AS t ON t.`emailtmpltext_emailtmpl_id` = r.emailtmpl_id AND l.lang_code = t.`emailtmpltext_lang_code`
";
$sql["get_detail_emailtemplate_altbody"] = "
SELECT
	l.`lang_code` AS `code`,
	t.`emailtmpltext_altbody` AS `text`
FROM
    (SELECT %d AS emailtmpl_id) r
LEFT JOIN gtfw_lang AS l ON 1 = 1
LEFT JOIN comp_email_template_text AS t ON t.`emailtmpltext_emailtmpl_id` = r.emailtmpl_id AND l.lang_code = t.`emailtmpltext_lang_code`
";
$sql["insert_emailtemplate"] = "
INSERT INTO comp_email_template
(
    emailtmpl_purpose,
    emailtmpl_subject,
    emailtmpl_from,
    emailtmpl_from_name,
    emailtmpl_attachment,
    emailtmpl_param,
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
    NOW()
)
";
$sql["update_emailtemplate"] = "
UPDATE comp_email_template
SET 
    emailtmpl_purpose = %s,
    emailtmpl_subject = %s,
    emailtmpl_from = %s,
    emailtmpl_from_name = %s,
    emailtmpl_attachment = %s,
    emailtmpl_param = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE emailtmpl_id = %d
";
$sql["delete_emailtemplate"] = "
DELETE FROM comp_email_template
WHERE emailtmpl_id = %d
";
$sql['insert_emailtemplate_text'] = "
INSERT INTO `comp_email_template_text`(
     `emailtmpltext_emailtmpl_id`,
     `emailtmpltext_lang_code`,
     `emailtmpltext_body`,
     `emailtmpltext_altbody`,
     `insert_user_id`,
     `insert_timestamp`
)VALUES (
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        NOW()
)    
";
$sql['delete_emailtemplate_text'] = "
DELETE
FROM `comp_email_template_text`
WHERE `emailtmpltext_emailtmpl_id` = '%s'    
";