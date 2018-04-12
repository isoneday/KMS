<?php

$sql["count_modkmsnews"] = "
SELECT 
    COUNT(news_id) AS total
FROM cms_news
WHERE
    1 = 1
    --search--
";
$sql["get_modkmsnews"] = "
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
    a.newscat_id AS `newscat_id`,
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
$sql["get_detail_modkmsnews"] = "
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
    a.newscat_id AS `newscat_id`,
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
$sql["list_modkmsnews"] = "
SELECT
    news_id AS `id`,
    news_name AS `name`
FROM
    cms_news
ORDER BY news_name
";