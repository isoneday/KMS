<?php

$sql["count_corecompany"] = "
SELECT FOUND_ROWS() AS total
";
$sql["get_corecompany"] = "
SELECT SQL_CALC_FOUND_ROWS
    a.company_id AS `id`,
    a.company_name AS `name`,
    a.company_address AS `address`,
    a.company_country_id AS `country`,
    c.`country_name` AS country_name,
    a.company_state_id AS `state`,
    d.`state_name` AS state_name,
    a.company_city_id AS `city`,
    e.`city_name` AS city_name,
    a.company_postal_code AS `postal_code`,
    a.company_phone AS `phone`,
    a.company_fax AS `fax`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM gtfw_company a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
LEFT JOIN ref_country c ON c.`country_id` = a.`company_country_id`
LEFT JOIN ref_state d ON d.`state_id` = a.`company_state_id`
LEFT JOIN ref_city e ON e.`city_id` = a.`company_city_id`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_corecompany"] = "
SELECT 
    a.company_id AS `id`,
    a.company_name AS `name`,
    a.company_address AS `address`,
    a.company_country_id AS `country`,
    c.`country_name` AS country_name,
    a.company_state_id AS `state`,
    d.`state_name` AS state_name,
    a.company_city_id AS `city`,
    e.`city_name` AS city_name,
    a.company_postal_code AS `postal_code`,
    a.company_phone AS `phone`,
    a.company_fax AS `fax`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM gtfw_company a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
LEFT JOIN ref_country c ON c.`country_id` = a.`company_country_id`
LEFT JOIN ref_state d ON d.`state_id` = a.`company_state_id`
LEFT JOIN ref_city e ON e.`city_id` = a.`company_city_id`
WHERE a.company_id = %d
";
$sql["insert_corecompany"] = "
INSERT INTO gtfw_company
(
    company_name,
    company_address,
    company_country_id,
    company_state_id,
    company_city_id,
    company_postal_code,
    company_phone,
    company_fax,
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
$sql["update_corecompany"] = "
UPDATE gtfw_company
SET 
    company_name = %s,
    company_address = %s,
    company_country_id = %s,
    company_state_id = %s,
    company_city_id = %s,
    company_postal_code = %s,
    company_phone = %s,
    company_fax = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE company_id = %d
";
$sql["delete_corecompany"] = "
DELETE FROM gtfw_company
WHERE company_id = %d
";
$sql['get_photo_type'] = "
SELECT
    phototype_id AS `photo_type_id`,
    phototype_msttype_id AS photo_type_mst_id,
    phototype_name AS `photo_type_name`
FROM
    ref_photo_type
WHERE phototype_msttype_id = '1'
ORDER BY phototype_name   
";
$sql['get_photo_type_by_id'] = "
SELECT
  b.`phototype_id` AS photo_type_id,
  b.`phototype_msttype_id` AS photo_type_mst_id,
  b.`phototype_name` AS photo_type_name,
  c.`logo_file` AS photo_ori,
  c.`logo_file_path` AS photo_enc,
  c.`logo_file_size` AS photo_size,
  c.`logo_file_type` AS photo_ext
FROM gtfw_company a,
     ref_photo_type b 
LEFT JOIN gtfw_company_logo c ON c.`logo_phototype_id` = b.`phototype_id` AND c.`logo_company_id` = '%s'
LEFT JOIN gtfw_company d ON d.`company_id` = c.`logo_company_id` AND d.`company_id` = '%s'
WHERE b.`phototype_msttype_id` = '1' AND a.`company_id` = '%s'
ORDER BY b.phototype_name   
";
$sql['insert_company_photo'] = "
INSERT INTO `gtfw_company_logo`(
    `logo_company_id`,
    `logo_phototype_id`,
    `logo_file`,
    `logo_file_path`,
    `logo_file_type`,
    `logo_file_size`
)VALUES (
    (SELECT MAX(company_id) FROM gtfw_company),
    '%s',
    '%s',
    '%s',
    '%s',
    '%s'
)
";
$sql['get_company_photo'] = "
SELECT 
    logo_file_path AS photo
FROM gtfw_company_logo
WHERE logo_company_id = '%s' AND logo_phototype_id = '%s'
";
$sql['delete_company_photo'] = "
DELETE
FROM gtfw_company_logo
WHERE logo_company_id = '%s' AND logo_phototype_id = '%s'
";
$sql['update_company_photo'] = "
INSERT INTO `gtfw_company_logo`(
    `logo_company_id`,
    `logo_phototype_id`,
    `logo_file`,
    `logo_file_path`,
    `logo_file_type`,
    `logo_file_size`
)VALUES (
    '%s',
    '%s',
    '%s',
    '%s',
    '%s',
    '%s'
)
";
$sql['list_company'] = "
SELECT
  `company_id` AS `id`,
  `company_name` AS `name`
FROM `gtfw_company`
ORDER BY company_name    
";
$sql['list_company_to_taf'] = "
SELECT
  a.`company_id` AS `id`,
  a.`company_name` AS `name`
FROM `gtfw_company` a
ORDER BY a.`company_name`   
";
$sql['list_company_transaction'] = "
SELECT
  CONCAT(a.`company_id`,'|', IFNULL(b.`unit_is_company`,'0'),'|', IFNULL(b.`unit_company_id`,'0'),'|', IFNULL(b.`unit_id`,'0')) AS `id`,
  a.`company_name` AS `name`
FROM `gtfw_company` a
LEFT JOIN gtfw_unit b ON b.`unit_company_id` = a.`company_id`
ORDER BY a.`company_name`   
";