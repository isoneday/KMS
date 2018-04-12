<?php

$sql["count_setting"] = "
SELECT FOUND_ROWS() AS total
";
$sql["get_setting"] = "
SELECT SQL_CALC_FOUND_ROWS
    setting_id AS `id`,
    setting_name AS `name`,
    setting_value AS `value`,
    setting_desc AS `desc`,
    insert_user_id AS `insert_user_id`,
    insert_timestamp AS `insert_timestamp`,
    update_user_id AS `update_user_id`,
    update_timestamp AS `update_timestamp`
FROM gtfw_setting
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_setting"] = "
SELECT 
    setting_id AS `id`,
    setting_name AS `name`,
    setting_value AS `value`,
    setting_desc AS `desc`,
    insert_user_id AS `insert_user_id`,
    insert_timestamp AS `insert_timestamp`,
    update_user_id AS `update_user_id`,
    update_timestamp AS `update_timestamp`
FROM gtfw_setting
WHERE setting_id = %d
";
$sql["insert_setting"] = "
INSERT INTO gtfw_setting
(
    setting_name,
    setting_value,
    setting_desc,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    %s,
    %s,
    NOW()
)
";
$sql["update_setting"] = "
UPDATE gtfw_setting
SET 
    setting_name = %s,
    setting_value = %s,
    setting_desc = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE setting_id = %d
";
$sql["delete_setting"] = "
DELETE FROM gtfw_setting
WHERE setting_id = %d
";
$sql['get_setting_value'] = '
SELECT 
  setting_value AS "value"
FROM
  gtfw_setting 
WHERE setting_name = %s
';
$sql['list_application'] = "
SELECT
  a.`application_id` AS id,
  a.`application_name` AS `name`
FROM `gtfw_application` a
WHERE 
   a.application_status = 1 
";