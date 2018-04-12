<?php

$sql["count_legalinformation"] = "
SELECT 
    COUNT(legal_id) AS total
FROM cms_legal_information
WHERE
    1 = 1
    --search--
";
$sql["get_legalinformation"] = "
SELECT 
    a.legal_id AS `id`,
    a.legal_title AS `title`,
    a.legal_content AS `content`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM cms_legal_information a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_legalinformation"] = "
SELECT 
    a.legal_id AS `id`,
    a.legal_title AS `title`,
    a.legal_content AS `content`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM cms_legal_information a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
ORDER BY id DESC
LIMIT 1
";
$sql["insert_legalinformation"] = "
INSERT INTO cms_legal_information
(
    legal_title,
    legal_content,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    %s,
    NOW()
)
";
$sql["update_legalinformation"] = "
UPDATE cms_legal_information
SET 
    legal_title = %s,
    legal_content = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE legal_id = %d
";
$sql["delete_legalinformation"] = "
DELETE FROM cms_legal_information
WHERE legal_id = %d
";
$sql["list_legalinformation"] = "
SELECT
    legal_id AS `id`,
    legal_name AS `name`
FROM
    cms_legal_information
ORDER BY legal_name
";