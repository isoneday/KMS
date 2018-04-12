<?php

$sql["count_sliderbanner"] = "
SELECT 
    COUNT(slider_id) AS total
FROM cms_slider_banner
WHERE
    1 = 1
    --search--
";
$sql["get_sliderbanner"] = "
SELECT 
    a.slider_id AS `id`,
    a.slider_title AS `title`,
    a.slider_photo AS `photo`,
    a.slider_photo_origin AS `photo_origin`,
    a.slider_photo_path AS `photo_path`,
    a.slider_photo_type AS `photo_type`,
    a.slider_photo_size AS `photo_size`,
    a.slider_status AS `status`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM cms_slider_banner a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_sliderbanner"] = "
SELECT 
    a.slider_id AS `id`,
    a.slider_title AS `title`,
    a.slider_photo AS `photo`,
    a.slider_photo_origin AS `photo_origin`,
    a.slider_photo_path AS `photo_path`,
    a.slider_photo_type AS `photo_type`,
    a.slider_photo_size AS `photo_size`,
    a.slider_status AS `status`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM cms_slider_banner a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE slider_id = %d
";
$sql["insert_sliderbanner"] = "
INSERT INTO cms_slider_banner
(
    slider_title,
    slider_photo,
    slider_photo_origin,
    slider_photo_path,
    slider_photo_type,
    slider_photo_size,
    slider_status,
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
    NOW()
)
";
$sql["update_sliderbanner"] = "
UPDATE cms_slider_banner
SET 
    slider_title = %s,
    slider_photo = %s,
    slider_photo_origin = %s,
    slider_photo_path = %s,
    slider_photo_type = %s,
    slider_photo_size = %s,
    slider_status = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE slider_id = %d
";
$sql["delete_sliderbanner"] = "
DELETE FROM cms_slider_banner
WHERE slider_id = %d
";
$sql["list_sliderbanner"] = "
SELECT
    slider_id AS `id`,
    slider_name AS `name`
FROM
    cms_slider_banner
ORDER BY slider_name
";