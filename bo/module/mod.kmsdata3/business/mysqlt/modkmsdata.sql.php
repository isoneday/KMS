<?php

$sql["count_modkmsdata"] = "
SELECT 
    COUNT(id_data) AS total
FROM kms_data
WHERE
    1 = 1
    --search--
";
$sql["get_modkmsdata"] = "
SELECT 
    a.id_data AS `data`,
    a.kmsdata_userid AS `kmsdata_userid`,
    a.kmsdata_idkategori AS `kmsdata_idkategori`,
    a.kmsdata_keyword AS `kmsdata_keyword`,
    a.filedata_enc AS `filedata_enc`,
    a.filedata_origin AS `filedata_origin`,
    a.filedata_txt AS `filedata_txt`,
    a.filedata_path AS `filedata_path`,
    a.filedata_type AS `filedata_type`,
    a.filedata_size AS `filedata_size`,
    a.time AS `time`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM kms_data a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_modkmsdata"] = "
SELECT 
    a.id_data AS `data`,
    a.kmsdata_userid AS `kmsdata_userid`,
    a.kmsdata_idkategori AS `kmsdata_idkategori`,
    a.kmsdata_keyword AS `kmsdata_keyword`,
    a.filedata_enc AS `filedata_enc`,
    a.filedata_origin AS `filedata_origin`,
    a.filedata_txt AS `filedata_txt`,
    a.filedata_path AS `filedata_path`,
    a.filedata_type AS `filedata_type`,
    a.filedata_size AS `filedata_size`,
    a.time AS `time`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM kms_data a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE id_data = %d
";
$sql["insert_modkmsdata"] = "
INSERT INTO kms_data
(
    id_data,
    kmsdata_userid,
    kmsdata_idkategori,
    kmsdata_keyword,
    filedata_enc,
    filedata_origin,
    filedata_txt,
    filedata_path,
    filedata_type,
    filedata_size,
    time
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
    %s
)
";
$sql["update_modkmsdata"] = "
UPDATE kms_data
SET 
    id_data = %s,
    kmsdata_userid = %s,
    kmsdata_idkategori = %s,
    kmsdata_keyword = %s,
    filedata_enc = %s,
    filedata_origin = %s,
    filedata_txt = %s,
    filedata_path = %s,
    filedata_type = %s,
    filedata_size = %s,
    time = %s
WHERE id_id = %d
";
$sql["delete_modkmsdata"] = "
DELETE FROM kms_data
WHERE id_id = %d
";
$sql["list_modkmsdata"] = "
SELECT
    id_id AS `id`,
    id_name AS `name`
FROM
    kms_data
ORDER BY id_name
";