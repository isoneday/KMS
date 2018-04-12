<?php

$sql["count_documentation"] = "
SELECT 
    COUNT(tabledoc_id) AS total
FROM gtfw_table_documentation
WHERE
    1 = 1
    --search--
";
$sql["get_documentation"] = "
SELECT 
    a.tabledoc_id AS `id`,
    a.tabledoc_name AS `name`,
    a.tabledoc_table AS `table`,
    a.tabledoc_dependency_source AS `dependency_source`,
    a.tabledoc_dependency_target AS `dependency_target`,
    a.tabledoc_desc AS `desc`,
    a.tabledoc_sample_data AS `sample_data`,
    a.tabledoc_menu_name AS `menu_name`,
    a.tabledoc_module_name AS `module_name`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    IF((a.update_timestamp = NULL OR a.update_timestamp = '1900-01-01 00:00:00' OR a.update_timestamp = '0000-00-00 00:00:00'), IF ( (a.insert_timestamp = NULL OR a.insert_timestamp = '1900-01-01 00:00:00' OR a.insert_timestamp = '0000-00-0 00:00:00'), b.`user_real_name`, CONCAT( b.`user_real_name`, ', ', DATE_FORMAT( a.insert_timestamp, '%d %b %Y %H:%i' ))),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM gtfw_table_documentation a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_documentation"] = "
SELECT 
    a.tabledoc_id AS `id`,
    a.tabledoc_name AS `name`,
    a.tabledoc_table AS `table`,
    a.tabledoc_dependency_source AS `dependency_source`,
    a.tabledoc_dependency_target AS `dependency_target`,
    a.tabledoc_desc AS `desc`,
    a.tabledoc_sample_data AS `sample_data`,
    a.tabledoc_menu_name AS `menu_name`,
    a.tabledoc_module_name AS `module_name`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM gtfw_table_documentation a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE tabledoc_id = %d
";
$sql["insert_documentation"] = "
INSERT INTO gtfw_table_documentation
(
    tabledoc_name,
    tabledoc_table,
    tabledoc_dependency_source,
    tabledoc_dependency_target,
    tabledoc_desc,
    tabledoc_sample_data,
    tabledoc_menu_name,
    tabledoc_module_name,
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
    %s,
    NOW()
)
";
$sql["update_documentation"] = "
UPDATE gtfw_table_documentation
SET 
    tabledoc_name = %s,
    tabledoc_table = %s,
    tabledoc_dependency_source = %s,
    tabledoc_dependency_target = %s,
    tabledoc_desc = %s,
    tabledoc_sample_data = %s,
    tabledoc_menu_name = %s,
    tabledoc_module_name = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE tabledoc_id = %d
";
$sql["delete_documentation"] = "
DELETE FROM gtfw_table_documentation
WHERE tabledoc_id = %d
";
$sql['list_table'] = "
SHOW TABLES
";
$sql['get_documented_table'] = "
SELECT 
  tabledoc_table AS `name`
FROM
  gtfw_table_documentation 
";
$sql['get_table_column'] = '
SHOW FULL COLUMNS FROM %s
';