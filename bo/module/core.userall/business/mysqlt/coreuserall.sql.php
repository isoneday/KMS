<?php

$sql["count_coreuserall"] = "
SELECT FOUND_ROWS() AS total
";
$sql["get_coreuserall"] = "
SELECT SQL_CALC_FOUND_ROWS
    a.user_id AS `id`,
    a.user_real_name AS `real_name`,
    a.user_user_name AS `name`,
    a.user_email AS `email`,
    a.user_password AS `password`,
    a.user_desc AS `desc`,
    a.user_no_password AS `no_password`,
    a.user_active AS `active`,
    a.user_force_logout AS `force_logout`,
    a.user_active_lang_code AS `active_lang_code`,
    a.user_last_logged_in AS `last_logged_in`,
    a.user_last_ip AS `last_ip`,
    a.insert_user_id AS `insert_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_id`,
    a.update_timestamp AS `update_timestamp`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM gtfw_user a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
LEFT JOIN gtfw_user_group c ON c.`usergroup_user_id` = a.`user_id`
WHERE
    1 = 1
    AND a.user_id != 0
    --search--
GROUP BY a.`user_id`
--limit--    
";
$sql["get_detail_coreuserall"] = "
SELECT 
    a.user_id AS `id`,
    a.user_real_name AS `real_name`,
    a.user_user_name AS `name`,
    a.user_email AS `email`,
    a.user_password AS `password`,
    a.user_desc AS `desc`,
    a.user_no_password AS `no_password`,
    a.user_active AS `active`,
    a.user_force_logout AS `force_logout`,
    a.user_active_lang_code AS `active_lang_code`,
    l.`lang_name` AS active_lang_name,
    a.user_last_logged_in AS `last_logged_in`,
    a.user_last_ip AS `last_ip`,
    a.insert_user_id AS `insert_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_id`,
    a.update_timestamp AS `update_timestamp`,
    GROUP_CONCAT(DISTINCT(CAST(CONCAT(g.group_id) AS CHAR))) AS `group`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM gtfw_user a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
LEFT JOIN gtfw_user_group ug ON ug.usergroup_user_id = a.user_id
LEFT JOIN gtfw_group g ON g.group_id = ug.usergroup_group_id
LEFT JOIN gtfw_lang l ON l.lang_code = a.user_active_lang_code
WHERE a.user_id = %d
";
$sql['get_user_group'] = "
SELECT
  a.`usergroup_group_id` AS group_id,
  c.`application_id` AS application_id,
  CONCAT(b.`group_name`,' [',c.`application_name`,']') AS group_name
FROM `gtfw_user_group` a
LEFT JOIN gtfw_group b ON b.`group_id` = a.`usergroup_group_id`
LEFT JOIN gtfw_application c ON c.`application_id` = b.`group_application_id`
WHERE a.`usergroup_user_id` = %d    
";
$sql["insert_coreuserall"] = "
INSERT INTO gtfw_user
(
    user_real_name,
    user_user_name,
    user_email,
    user_password,
    user_desc,
    user_active,
    user_active_lang_code,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    %s,
    MD5(%s),
    %s,
    %s,
    %s,
    %s,
    NOW()
)
";
$sql['add_user_group'] = "
INSERT INTO gtfw_user_group (
  usergroup_user_id,
  usergroup_group_id
) 
SELECT 
  %s AS user_id,
  g.group_id 
FROM
  gtfw_group g 
WHERE group_id IN (%s)
";
$sql["update_coreuserall"] = "
UPDATE gtfw_user
SET 
    user_real_name = %s,
    user_user_name = %s,
    user_email = %s,
    user_desc = %s,
    user_active = %s,
    user_active_lang_code = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE user_id = %d
";
$sql["delete_coreuserall"] = "
DELETE FROM gtfw_user
WHERE user_id = %d
";
$sql['delete_user_group'] = "
DELETE FROM gtfw_user_group
WHERE
    usergroup_user_id = %d
";