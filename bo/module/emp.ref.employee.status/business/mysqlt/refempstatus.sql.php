<?php

$sql["count_status"] = "
	SELECT FOUND_ROWS() as total    
";
$sql["get_status"] = "
SELECT SQL_CALC_FOUND_ROWS
    a.empstat_id AS `id`,
    a.empstat_name AS `name`,
    a.empstat_is_active AS `is_active`,
    a.empstat_order AS `order`,
    a.empstat_status AS `status`,
    a.empstat_desc AS `desc`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    a.unit_id AS `unit_id`,
    IF((a.update_timestamp = NULL OR a.update_timestamp = '1900-01-01 00:00:00' OR a.update_timestamp = '0000-00-00 00:00:00'), IF ( (a.insert_timestamp = NULL OR a.insert_timestamp = '1900-01-01 00:00:00' OR a.insert_timestamp = '0000-00-0 00:00:00'), u1.`user_real_name`, CONCAT( u1.`user_real_name`, ', ', DATE_FORMAT( a.insert_timestamp, '%d %b %Y %H:%i' ))),CONCAT(u2.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM emp_ref_employee_status a
LEFT JOIN gtfw_user u1 ON u1.`user_id` = a.`insert_user_id`
LEFT JOIN gtfw_user u2 ON u2.`user_id` = a.`update_user_id`
WHERE
    1 = 1
    --search--
ORDER BY 
    a.empstat_order ASC
--limit--    
";
$sql["get_detail_status"] = "
SELECT 
    a.empstat_id AS `id`,
    a.empstat_name AS `name`,
    a.empstat_is_active AS `is_active`,
    a.empstat_order AS `order`,
    a.empstat_status AS `status`,
    a.empstat_desc AS `desc`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    a.unit_id AS `unit_id`,
    IF((a.insert_timestamp = NULL OR a.insert_timestamp = '1900-01-01 00:00:00' OR a.insert_timestamp = '0000-00-0 00:00:00'), u1.user_real_name, CONCAT(u1.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i'))) AS last_insert ,
    IF((a.update_timestamp = NULL OR a.update_timestamp = '1900-01-01 00:00:00' OR a.update_timestamp = '0000-00-00 00:00:00'), u2.user_real_name, CONCAT(u2.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i'))) AS last_update   
FROM emp_ref_employee_status a
LEFT JOIN gtfw_user u1 ON u1.`user_id` = a.`insert_user_id`    
LEFT JOIN gtfw_user u2 ON u2.`user_id` = a.`update_user_id`
WHERE empstat_id = %d
";
$sql["insert_status"] = "
INSERT INTO emp_ref_employee_status
(
    empstat_name,
    empstat_is_active,
    empstat_order,
    empstat_status,
    empstat_desc,
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
$sql["update_status"] = "
UPDATE emp_ref_employee_status
SET 
    empstat_name = %s,
    empstat_is_active = %s,
    empstat_order = %s,
    empstat_status = %s,
    empstat_desc = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE empstat_id = %d
";
$sql["delete_status"] = "
DELETE FROM emp_ref_employee_status
WHERE empstat_id = %d
";
$sql["list_status"] = "
SELECT
    empstat_id AS `id`,
    empstat_name AS `name`
FROM
    emp_ref_employee_status
WHERE empstat_status = 1
ORDER BY empstat_order ASC
";