<?php

$sql["count_unit"] = "
SELECT 
    COUNT(a.unit_id) AS total
FROM gtfw_unit a
LEFT JOIN gtfw_unit b ON b.`unit_id` = a.`unit_parent_id`
WHERE
    1 = 1
    --search--
";
$sql["get_unit"] = "
SELECT 
    a.unit_id AS `id`,
    a.unit_parent_id AS `parent_id`,
    c.`unit_name` AS parent,
    a.unit_level AS `level`,
    a.unit_code AS code,
    a.unit_name AS `name`,
    a.unit_desc AS `description`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    IF((a.update_timestamp = NULL OR a.update_timestamp = '1900-01-01 00:00:00' OR a.update_timestamp = '0000-00-00 00:00:00'), IF ( (a.insert_timestamp = NULL OR a.insert_timestamp = '1900-01-01 00:00:00' OR a.insert_timestamp = '0000-00-0 00:00:00'), b.`user_real_name`, CONCAT( b.`user_real_name`, ', ', DATE_FORMAT( a.insert_timestamp, '%d %b %Y %H:%i' ))),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM gtfw_unit a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
LEFT JOIN gtfw_unit c ON c.`unit_id` = a.`unit_parent_id`
WHERE
    1 = 1
    --search--
ORDER BY a.unit_parent_id    
--limit--    
";
$sql["get_detail_core_unit"] = "
SELECT 
    a.unit_id AS `id`,
    a.unit_parent_id AS `parent_id`,
    c.`unit_name` AS parent,
    a.unit_level AS `level`,
    a.unit_code AS code,
    a.unit_name AS `name`,
    a.unit_desc AS `description`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM gtfw_unit a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
LEFT JOIN gtfw_unit c ON c.`unit_id` = a.`unit_parent_id`
WHERE a.unit_id = %d
";
$sql["get_detail_core_unit_to_order"] = "
SELECT 
    a.unit_id AS `id`,
    a.unit_parent_id AS `parent_id`,
    c.`unit_name` AS parent,
    a.unit_level AS `level`,
    a.unit_code AS 'code',
    a.unit_name AS `name`,
    a.unit_desc AS `description`,
    d.`emparea_emp_id` AS emp_id,
    CONCAT(e.`emp_name`,' (',a.`unit_name`,')') AS van_name
FROM gtfw_unit a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
LEFT JOIN gtfw_unit c ON c.`unit_id` = a.`unit_parent_id`
LEFT JOIN pcs_employee_area d ON d.`emparea_van_unit_id` = a.`unit_id`
LEFT JOIN emp_employee e ON e.`emp_id` = d.`emparea_emp_id`
WHERE a.unit_id = %d
";
$sql["get_emp_detail_core_unit_to_order"] = "
SELECT 
    a.unit_id AS `id`,
    a.unit_parent_id AS `parent_id`,
    c.`unit_name` AS parent,
    a.unit_level AS `level`,
    a.unit_code AS 'code',
    a.unit_name AS `name`,
    a.unit_desc AS `description`,
    d.`emparea_emp_id` AS emp_id,
    CONCAT(e.`emp_name`,' (',a.`unit_name`,')') AS van_name
FROM gtfw_unit a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
LEFT JOIN gtfw_unit c ON c.`unit_id` = a.`unit_parent_id`
LEFT JOIN pcs_employee_area d ON d.`emparea_van_unit_id` = a.`unit_id`
LEFT JOIN emp_employee e ON e.`emp_id` = d.`emparea_emp_id`
WHERE e.`emp_id` = %d
";
$sql["insert_unit"] = "
INSERT INTO gtfw_unit
(
    unit_parent_id,
    unit_code,
    unit_name,
    unit_desc,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    %s,
    %s,
    %s,
    NOW()
)
";
$sql["update_unit"] = "
UPDATE gtfw_unit
SET 
    unit_parent_id = %s,
    unit_code = %s,
    unit_name = %s,
    unit_desc = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE unit_id = %d
";
$sql["delete_unit"] = "
DELETE FROM gtfw_unit
WHERE unit_id = %d
";
$sql["list_unit"] = "
SELECT
    unit_id AS `id`,
    unit_name AS `name`,
    unit_parent_id AS parent_id
FROM
    gtfw_unit
ORDER BY unit_name
";
$sql["list_unit_to_report"] = "
SELECT
    unit_id AS `id`,
    unit_code AS `name`,
    unit_parent_id AS parent_id
FROM
    gtfw_unit
ORDER BY unit_name
";
$sql['list_unit_to_profit'] = "
SELECT
    a.unit_id AS `id`,
    CONCAT(a.unit_name,' (',IFNULL(a.unit_code,'-'),')') AS `name`,
    a.unit_parent_id AS parent_id
FROM
    gtfw_unit a
WHERE a.`unit_id` NOT IN (SELECT b.`unit_unit_id` FROM crm_ref_unit b)
ORDER BY a.unit_name    
";
$sql["list_unit_to_profit_detail"] = "
SELECT
    a.unit_unit_id AS `id`,
    b.unit_name AS `name`
FROM
    crm_ref_unit a
LEFT JOIN gtfw_unit b ON b.`unit_id` = a.`unit_unit_id`
WHERE a.`unit_status` = 1
ORDER BY b.unit_name
";
$sql["get_detail_unit"] = "
SELECT 
  u.unit_id AS `id`,
  unit_parent_id AS `parent_id`,
  unit_level AS `level`,
  unit_name AS `name`,
  branch_code AS `code`,
  unit_desc AS `description`,
  u.insert_user_id AS `insert_user_id`,
  u.insert_timestamp AS `insert_timestamp`,
  u.update_user_id AS `update_user_id`,
  u.update_timestamp AS `update_timestamp` 
FROM
  gtfw_unit AS u 
  LEFT JOIN inv_branch 
    ON u.unit_id = branch_unit_id 
WHERE u.unit_id = %d
";

$sql['list_unit_by_parent'] = "
SELECT 
  unit_id AS `id`,
  unit_name AS `name` 
FROM
  gtfw_unit 
WHERE unit_parent_id = '%s' 
";
$sql['list_unit_by_parent_to_order'] = "
SELECT 
  CONCAT(a.unit_id,'|',c.`emp_id`) AS `id`,
  CONCAT(c.`emp_name`,' (',a.unit_name,')') AS `name` 
FROM
  gtfw_unit a
  LEFT JOIN pcs_employee_area b ON b.`emparea_van_unit_id` = a.`unit_id`
  LEFT JOIN emp_employee c ON c.`emp_id` = b.`emparea_emp_id`
WHERE a.unit_parent_id = '%s' 
";
$sql['get_emp_by_parent_to_order'] = "
SELECT 
  c.`emp_id` AS `id`,
  CONCAT(c.`emp_name`,' (',a.unit_name,')') AS `name` 
FROM
  gtfw_unit a
  LEFT JOIN pcs_employee_area b ON b.`emparea_van_unit_id` = a.`unit_id`
  LEFT JOIN emp_employee c ON c.`emp_id` = b.`emparea_emp_id`
WHERE c.`emp_id` = %d
";
$sql['list_unit_to_contract_summary'] = "
SELECT
    a.unit_id AS `id`,
    CONCAT(a.unit_name,' (',IFNULL(a.unit_code,'-'),')') AS `name`,
    a.unit_parent_id AS parent_id
FROM
crm_ref_unit d
LEFT JOIN gtfw_unit a ON a.`unit_id` = d.`unit_unit_id`
LEFT JOIN crm_opportunity b ON b.`opportunity_unit_id` = a.`unit_id`
LEFT JOIN crm_contract c ON c.`contract_opportunity_id` = b.`opportunity_id`
WHERE d.`unit_status` = 1
GROUP BY a.`unit_id`
ORDER BY unit_name    
";
$sql['list_unit_to_opportunity_summary'] = "
SELECT
    c.unit_id AS `id`,
    CONCAT(a.unit_name,' (',IFNULL(a.unit_code,'-'),')') AS `name`,
    a.unit_parent_id AS parent_id
FROM
crm_ref_unit c
LEFT JOIN gtfw_unit a ON a.`unit_id` = c.`unit_unit_id`
LEFT JOIN crm_opportunity b ON b.`opportunity_unit_id` = c.`unit_id`
WHERE c.`unit_status` = '1'
GROUP BY c.`unit_id`
ORDER BY a.unit_name    
";
$sql['list_unit_to_ga'] = "
SELECT
    a.unit_id AS `id`,
    CONCAT(a.unit_name,' (',IFNULL(a.unit_code,'-'),')') AS `name`,
    a.unit_parent_id AS parent_id
FROM
    gtfw_unit a
WHERE a.`unit_id` NOT IN (SELECT b.`unit_unit_id` FROM ga_ref_unit b)
ORDER BY a.unit_name    
";
$sql["list_unit_to_ga_detail"] = "
SELECT
    a.unit_unit_id AS `id`,
    b.unit_name AS `name`
FROM
    ga_ref_unit a
LEFT JOIN gtfw_unit b ON b.`unit_id` = a.`unit_unit_id`
WHERE a.`unit_status` = 1
ORDER BY b.unit_name
";
$sql['list_unit_to_tf'] = "
SELECT
    a.unit_id AS `id`,
    CONCAT(a.unit_name,' (',IFNULL(a.unit_code,'-'),')') AS `name`,
    a.unit_parent_id AS parent_id
FROM
    gtfw_unit a
WHERE a.`unit_id` NOT IN (SELECT b.`unit_unit_id` FROM taf_ref_unit b)
ORDER BY a.unit_name    
";
$sql["list_unit_to_tf_detail"] = "
SELECT
    a.unit_unit_id AS `id`,
    b.unit_name AS `name`
FROM
    taf_ref_unit a
LEFT JOIN gtfw_unit b ON b.`unit_id` = a.`unit_unit_id`
WHERE a.`unit_status` = 1
ORDER BY b.unit_name
";
$sql['list_unit_to_bg_unit'] = "
SELECT
    a.unit_id AS `id`,
    CONCAT(a.unit_name,' (',IFNULL(a.unit_code,'-'),')') AS `name`,
    a.unit_parent_id AS parent_id
FROM
    gtfw_unit a
WHERE a.`unit_id` NOT IN (SELECT b.`bgunit_unit_id` FROM fin_ref_bg_unit b)
ORDER BY a.unit_name 
";
$sql['list_unit_to_bg_unit_detail'] = "
SELECT
    a.`bgunit_unit_id`AS `id`,
    b.unit_name AS `name`
FROM
    fin_ref_bg_unit a
LEFT JOIN gtfw_unit b ON b.`unit_id` = a.`bgunit_unit_id`
WHERE a.`bgunit_status` = 1
ORDER BY b.unit_name
";
$sql['list_unit_to_proj'] = "
SELECT
    a.unit_id AS `id`,
    CONCAT(a.unit_name,' (',IFNULL(a.unit_code,'-'),')') AS `name`,
    a.unit_parent_id AS parent_id
FROM
    gtfw_unit a
WHERE a.`unit_id` NOT IN (SELECT b.`unit_unit_id` FROM proj_ref_unit b)
ORDER BY a.unit_name    
";
$sql["list_unit_to_proj_detail"] = "
SELECT
    a.unit_unit_id AS `id`,
    b.unit_name AS `name`
FROM
    proj_ref_unit a
LEFT JOIN gtfw_unit b ON b.`unit_id` = a.`unit_unit_id`
WHERE a.`unit_status` = 1
ORDER BY b.unit_name
";
$sql['list_unit_to_cms'] = "
SELECT
    a.unit_id AS `id`,
    CONCAT(a.unit_name,' (',IFNULL(a.unit_code,'-'),')') AS `name`,
    a.unit_parent_id AS parent_id
FROM
    gtfw_unit a
WHERE a.`unit_id` NOT IN (SELECT b.`unit_unit_id` FROM cms_ref_unit b)
ORDER BY a.unit_name    
";
$sql["list_unit_to_cms_detail"] = "
SELECT
    a.unit_unit_id AS `id`,
    b.unit_name AS `name`
FROM
    cms_ref_unit a
LEFT JOIN gtfw_unit b ON b.`unit_id` = a.`unit_unit_id`
WHERE a.`unit_status` = 1
ORDER BY b.unit_name
";