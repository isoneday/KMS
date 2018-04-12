<?php

$sql['get_default_lang'] = "
SELECT
  `setting_id` AS `id`,
  `setting_name` AS `name`,
  `setting_value` AS `value`
FROM `gtfw_setting`
WHERE setting_name = %d    
";
$sql["get_email_template"] = "
SELECT
  a.`emailtmpltext_emailtmpl_id` AS tmpl_id,
  a.`emailtmpltext_lang_code` AS tmpl_code,
  a.`emailtmpltext_body` AS tmpl_body,
  a.`emailtmpltext_altbody` AS tmpl_altbody,
  a.`emailtmpltext_status` AS tmpl_status,
  a.`emailtmpltext_desc` AS tmpl_desc,
  b.`emailtmpl_from` AS tmpl_from,
  b.`emailtmpl_from_name` AS tmpl_from_name,
  b.`emailtmpl_purpose` AS tmpl_purpose,
  b.`emailtmpl_subject` AS tmpl_subject
FROM `comp_email_template_text` a
LEFT JOIN comp_email_template b ON b.`emailtmpl_id` = a.`emailtmpltext_emailtmpl_id`
WHERE b.`emailtmpl_purpose` = %s
AND a.`emailtmpltext_lang_code` = %s
";
$sql['get_data_application'] = "
SELECT
  `application_id` AS `id`,
  `application_name` AS `name`,
  `application_desc` AS `desc`
FROM `gtfw_application`
WHERE application_id = %d    
";