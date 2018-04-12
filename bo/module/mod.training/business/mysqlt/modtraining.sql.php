<?php

$sql["count_modtraining"] = "
SELECT 
    COUNT(id_training) AS total
FROM kms_training
WHERE
    1 = 1
    --search--
";
$sql["get_modtraining"] = "
SELECT 
    a.id_training AS `training`,
    a.kmstraining_userid AS `kmstraining_userid`,
    a.judul AS `judul`,
    a.jenis AS `jenis`,
    a.pembicara AS `pembicara`,
    a.lokasi AS `lokasi`,
    a.peserta AS `peserta`,
    a.tanggal AS `tanggal`,
    a.filedata_enc AS `filedata_enc`,
    a.filedata_origin AS `filedata_origin`,
    a.filedata_txt AS `filedata_txt`,
    a.filedata_path AS `filedata_path`,
    a.filedata_type AS `filedata_type`,
    a.filedata_size AS `filedata_size`,
    a.time AS `time`

FROM kms_training a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`kmstraining_userid`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_modtraining"] = "
SELECT 
    a.id_training AS `training`,
    a.kmstraining_userid AS `kmstraining_userid`,
    a.judul AS `judul`,
    a.jenis AS `jenis`,
    a.pembicara AS `pembicara`,
    a.lokasi AS `lokasi`,
    a.peserta AS `peserta`,
    a.tanggal AS `tanggal`,
    a.filedata_enc AS `filedata_enc`,
    a.filedata_origin AS `filedata_origin`,
    a.filedata_txt AS `filedata_txt`,
    a.filedata_path AS `filedata_path`,
    a.filedata_type AS `filedata_type`,
    a.filedata_size AS `filedata_size`,
    a.time AS `time`
FROM kms_training a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE id_training = %d
";
$sql["list_modtraining"] = "
SELECT
    id_id AS `id`,
    id_name AS `name`
FROM
    kms_training
ORDER BY id_name
";