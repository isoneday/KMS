<?php

$sql["count_searchengine"] = "
SELECT FOUND_ROWS() AS total
";
$sql["get_searchengine"] = "
SELECT SQL_CALC_FOUND_ROWS
    a.id_data AS `data`,
    a.kmsdata_userid AS `kmsdata_userid`,
    a.kmsdata_idkategori AS `kmsdata_idkategori`,
    a.kmsdata_keyword AS `kmsdata_keyword`,
    a.filedata_enc AS `filedata_enc`,
    a.filedata_origin AS `filedata_origin`,
    a.filedata_path AS `filedata_path`,
    a.filedata_type AS `filedata_type`,
    a.filedata_size AS `filedata_size`
FROM kms_data a
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_searchengine"] = "
SELECT 
    a.id_data AS `data`,
    a.kmsdata_userid AS `kmsdata_userid`,
    a.kmsdata_idkategori AS `kmsdata_idkategori`,
    a.kmsdata_keyword AS `kmsdata_keyword`,
    a.filedata_enc AS `filedata_enc`,
    a.filedata_origin AS `filedata_origin`,
    a.filedata_path AS `filedata_path`,
    a.filedata_type AS `filedata_type`,
    a.filedata_size AS `filedata_size`
FROM kms_data a
WHERE id_data = %d
";
$sql["list_searchengine"] = "
SELECT
    id_id AS `id`,
    id_name AS `name`
FROM
    kms_data
ORDER BY id_name
";