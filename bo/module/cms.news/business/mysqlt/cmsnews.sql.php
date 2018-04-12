<?php

$sql["count_cmsnews"] = "
SELECT FOUND_ROWS() AS total
";
$sql["get_cmsnews"] = "
SELECT SQL_CALC_FOUND_ROWS
    a.news_id AS `id`,
    a.news_title AS `title`,
    a.news_content AS `content`,
    a.news_snippet AS `snippet`,
    a.news_photo AS `photo`,
    a.news_photo_origin AS `photo_origin`,
    a.news_photo_path AS `photo_path`,
    a.news_photo_type AS `photo_type`,
    a.news_photo_size AS `photo_size`,
    a.news_status AS `status`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM cms_news a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_cmsnews"] = "
SELECT 
    a.news_id AS `id`,
    a.news_title AS `title`,
    a.news_content AS `content`,
    a.news_snippet AS `snippet`,
    a.news_photo AS `photo`,
    a.news_photo_origin AS `photo_origin`,
    a.news_photo_path AS `photo_path`,
    a.news_photo_type AS `photo_type`,
    a.news_photo_size AS `photo_size`,
    a.news_status AS `status`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM cms_news a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE news_id = %d
";
$sql["insert_cmsnews"] = "
INSERT INTO cms_news
(
    news_title,
    news_content,
    news_snippet,
    news_photo,
    news_photo_origin,
    news_photo_path,
    news_photo_type,
    news_photo_size,
    news_status,
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
    %s,
    NOW()
)
";
$sql["update_cmsnews"] = "
UPDATE cms_news
SET 
    news_title = %s,
    news_content = %s,
    news_snippet = %s,
    news_photo = %s,
    news_photo_origin = %s,
    news_photo_path = %s,
    news_photo_type = %s,
    news_photo_size = %s,
    news_status = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE news_id = %d
";
$sql["delete_cmsnews"] = "
DELETE FROM cms_news
WHERE news_id = %d
";
$sql["list_cmsnews"] = "
SELECT
    news_id AS `id`,
    news_title AS `name`
FROM
    cms_news
ORDER BY news_title
";