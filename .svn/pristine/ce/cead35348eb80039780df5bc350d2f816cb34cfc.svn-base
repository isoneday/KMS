<?php

$sql["count_companyprofile"] = "
SELECT 
    COUNT(company_id) AS total
FROM cms_company_profile
WHERE
    1 = 1
    --search--
";
$sql["get_companyprofile"] = "
SELECT 
    a.company_id AS `id`,
    a.company_title AS `title`,
    a.company_content AS `content`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM cms_company_profile a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_companyprofile"] = "
SELECT 
    a.company_id AS `id`,
    a.company_title AS `title`,
    a.company_content AS `content`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM cms_company_profile a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
ORDER BY id DESC
LIMIT 1
";
$sql["insert_companyprofile"] = "
INSERT INTO cms_company_profile
(
    company_title,
    company_content,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    %s,
    NOW()
)
";
$sql["update_companyprofile"] = "
UPDATE cms_company_profile
SET 
    company_title = %s,
    company_content = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE company_id = %d
";
$sql["delete_companyprofile"] = "
DELETE FROM cms_company_profile
WHERE company_id = %d
";
$sql["list_companyprofile"] = "
SELECT
    company_id AS `id`,
    company_name AS `name`
FROM
    cms_company_profile
ORDER BY company_name
";