<?php

$sql["count_type"] = "
	SELECT FOUND_ROWS() as total    
";
$sql["get_type"] = "
SELECT SQL_CALC_FOUND_ROWS
    a.emptype_id AS `id`,
    a.emptype_name AS `name`,
    a.emptype_is_permanent AS `is_permanent`,
    a.emptype_order AS `order`,
    a.emptype_status AS `status`,
    a.emptype_desc AS `desc`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    a.unit_id AS `unit_id`,
    IF((a.update_timestamp = NULL OR a.update_timestamp = '1900-01-01 00:00:00' OR a.update_timestamp = '0000-00-00 00:00:00'), IF ( (a.insert_timestamp = NULL OR a.insert_timestamp = '1900-01-01 00:00:00' OR a.insert_timestamp = '0000-00-0 00:00:00'), u1.`user_real_name`, CONCAT( u1.`user_real_name`, ', ', DATE_FORMAT( a.insert_timestamp, '%d %b %Y %H:%i' ))),CONCAT(u2.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM emp_ref_employee_type a
LEFT JOIN gtfw_user u1 ON u1.`user_id` = a.`insert_user_id`
LEFT JOIN gtfw_user u2 ON u2.`user_id` = a.`update_user_id`
WHERE
    1 = 1
    --search--
ORDER BY 
    a.emptype_order ASC
--limit--    
";
$sql["get_detail_type"] = "
SELECT 
    a.emptype_id AS `id`,
    a.emptype_name AS `name`,
    a.emptype_is_permanent AS `is_permanent`,
    a.emptype_order AS `order`,
    a.emptype_status AS `status`,
    a.emptype_desc AS `desc`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    a.unit_id AS `unit_id`,
    IF((a.insert_timestamp = NULL OR a.insert_timestamp = '1900-01-01 00:00:00' OR a.insert_timestamp = '0000-00-0 00:00:00'), u1.user_real_name, CONCAT(u1.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i'))) AS last_insert ,
    IF((a.update_timestamp = NULL OR a.update_timestamp = '1900-01-01 00:00:00' OR a.update_timestamp = '0000-00-00 00:00:00'), u2.user_real_name, CONCAT(u2.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i'))) AS last_update   
FROM emp_ref_employee_type a
LEFT JOIN gtfw_user u1 ON u1.`user_id` = a.`insert_user_id`    
LEFT JOIN gtfw_user u2 ON u2.`user_id` = a.`update_user_id`
WHERE emptype_id = %d
";
$sql["insert_type"] = "
INSERT INTO emp_ref_employee_type
(
    emptype_name,
    emptype_is_permanent,
    emptype_order,
    emptype_status,
    emptype_desc,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    NOW()
)
";
$sql["update_type"] = "
UPDATE emp_ref_employee_type
SET 
    emptype_name = %s,
    emptype_is_permanent = %s,
    emptype_order = %s,
    emptype_status = %s,
    emptype_desc = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE emptype_id = %d
";
$sql["delete_type"] = "
DELETE FROM emp_ref_employee_type
WHERE emptype_id = %d
";
$sql["list_type"] = "
SELECT
    emptype_id AS `id`,
    emptype_name AS `name`
FROM
    emp_ref_employee_type
WHERE emptype_status = 1
ORDER BY emptype_name
";
$sql["list_type_to_transfer"] = "
SELECT
    CONCAT(emptype_id,'|',emptype_is_permanent) AS `id`,
    emptype_name AS `name`
FROM
    emp_ref_employee_type
WHERE emptype_status = 1
ORDER BY emptype_order ASC
";