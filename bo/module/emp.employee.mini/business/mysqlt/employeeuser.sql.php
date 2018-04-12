<?php

$sql['get_application'] = "
SELECT  
	application_id AS app_id, 
	application_name AS app_name
FROM gtfw_application
WHERE application_id IN (
   SELECT group_application_id FROM gtfw_group
)    
";
$sql["count_employeeuser"] = "
SELECT 
    COUNT(empuser_id) AS total
FROM emp_employee_user
WHERE
    1 = 1
    --search--
";
$sql["get_employeeuser"] = "
SELECT 
    a.empuser_id AS `id`,
    a.empuser_emp_id AS `emp_id`,
    a.empuser_user_id AS `user_id`,
    a.empuser_desc AS `desc`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    a.unit_id AS `unit_id`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM emp_employee_user a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_employeeuser"] = "
SELECT 
    user_id AS `id`,
    user_real_name AS `real_name`,
    user_user_name AS `name`,
    user_email AS `email`,
    user_password AS `password`,
    user_desc AS `desc`,
    user_no_password AS `no_password`,
    user_active AS `active`,
    user_active AS `status`,
    user_force_logout AS `force_logout`,
    user_active_lang_code AS `active_lang_code`,
    user_last_logged_in AS `last_logged_in`,
    user_last_ip AS `last_ip`,
    u.insert_user_id AS `insert_id`,
    u.insert_timestamp AS `insert_timestamp`,
    u.update_user_id AS `update_id`,
    u.update_timestamp AS `update_timestamp`,
    GROUP_CONCAT(DISTINCT(CAST(CONCAT(g.group_id) AS CHAR))) AS `group`
FROM gtfw_user u
LEFT JOIN gtfw_user_group ug ON ug.usergroup_user_id = u.user_id
LEFT JOIN gtfw_group g ON g.group_id = ug.usergroup_group_id
LEFT JOIN emp_employee_user h ON h.`empuser_user_id` = u.`user_id`
WHERE h.`empuser_emp_id` = %d	
";
$sql["insert_user"] = "
INSERT INTO gtfw_user
(
    user_real_name,
    user_user_name,
    user_email,
    user_password,
    user_desc,
    user_active,
    user_force_logout,
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
    %s,
    NOW()
)
";
$sql["insert_employeeuser"] = "
INSERT INTO `emp_employee_user`
        (
        `empuser_emp_id`,
        `empuser_user_id`,
        `empuser_desc`,
        `insert_user_id`,
        `insert_timestamp`
        )
VALUES (
        '%s',
        '%s',
        '%s',
        '%s',
        NOW()
	);
";
$sql["update_user"] = "
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
$sql["update_employeeuser"] = "
UPDATE `emp_employee_user`
SET
    `empuser_user_id` = %s,
    `empuser_desc` = %s,
    `update_user_id` = %s,
    `update_timestamp` = NOW()
WHERE empuser_emp_id = %d
";
$sql["delete_employeeuser"] = "
DELETE FROM emp_employee_user
WHERE empuser_id = %d
";
$sql['delete_user_group'] = "
DELETE 
FROM
  gtfw_user_group 
WHERE usergroup_user_id = %d
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
$sql['get_user_data'] = "
SELECT 
a.empuser_user_id AS user_id,
b.`user_user_name` AS user_name
FROM emp_employee_user a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`empuser_user_id`
WHERE a.`empuser_emp_id` = %d    
";
$sql["reset_password"] = "
UPDATE gtfw_user
SET 
    user_password = MD5(%s),
    update_user_id = %s,
    update_timestamp = NOW()
WHERE user_id = %d
";
$sql['get_user_id_by_employee'] = "
SELECT
  `empuser_id` AS id,
  `empuser_emp_id` AS emp_id,
  `empuser_user_id` AS user_id
FROM `emp_employee_user`
WHERE empuser_emp_id = %d    
";
$sql['get_user_id_by_asset_varian'] = "
SELECT
  a.`empuser_id` AS id,
  a.`empuser_emp_id` AS emp_id,
  a.`empuser_user_id` AS user_id
FROM `emp_employee_user` a
LEFT JOIN fxa_officer b ON b.`officer_emp_id` = a.`empuser_emp_id`
LEFT JOIN fxa_officer_asset_varian c ON c.`officerassetvar_officer_id` = b.`officer_id`
WHERE c.`officerassetvar_assetvar_id` = %d
GROUP BY a.`empuser_emp_id`    
";