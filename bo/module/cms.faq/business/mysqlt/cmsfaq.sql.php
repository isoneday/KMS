<?php

$sql["count_cmsfaq"] = "
SELECT 
    COUNT(faq_id) AS total
FROM cms_faq
WHERE
    1 = 1
    --search--
";
$sql["get_cmsfaq"] = "
SELECT 
    a.faq_id AS `id`,
    a.faq_question AS `question`,
    a.faq_answer AS `answer`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM cms_faq a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_cmsfaq"] = "
SELECT 
    a.faq_id AS `id`,
    a.faq_question AS `question`,
    a.faq_answer AS `answer`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM cms_faq a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE faq_id = %d
";
$sql["insert_cmsfaq"] = "
INSERT INTO cms_faq
(
    faq_question,
    faq_answer,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    %s,
    NOW()
)
";
$sql["update_cmsfaq"] = "
UPDATE cms_faq
SET 
    faq_question = %s,
    faq_answer = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE faq_id = %d
";
$sql["delete_cmsfaq"] = "
DELETE FROM cms_faq
WHERE faq_id = %d
";
$sql["list_cmsfaq"] = "
SELECT
    faq_id AS `id`,
    faq_name AS `name`
FROM
    cms_faq
ORDER BY faq_name
";