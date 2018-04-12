<?php

$sql["count_termcondition"] = "
SELECT 
    COUNT(term_id) AS total
FROM cms_term
WHERE
    1 = 1
    --search--
";
$sql["get_termcondition"] = "
SELECT 
    a.term_id AS `id`,
    a.term_title AS `title`,
    a.term_content AS `content`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM cms_term a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_termcondition"] = "
SELECT 
    a.term_id AS `id`,
    a.term_title AS `title`,
    a.term_content AS `content`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM cms_term a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
ORDER BY id DESC
LIMIT 1
";
$sql["insert_termcondition"] = "
INSERT INTO cms_term
(
    term_title,
    term_content,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    %s,
    NOW()
)
";
$sql["update_termcondition"] = "
UPDATE cms_term
SET 
    term_title = %s,
    term_content = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE term_id = %d
";
$sql["delete_termcondition"] = "
DELETE FROM cms_term
WHERE term_id = %d
";
$sql["list_termcondition"] = "
SELECT
    term_id AS `id`,
    term_name AS `name`
FROM
    cms_term
ORDER BY term_name
";