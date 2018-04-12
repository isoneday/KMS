<?php

$sql["count_modkms"] = "
SELECT 
    COUNT(id_training) AS total
FROM kms_training
WHERE
    1 = 1
    --search--
";
$sql["get_modkms"] = "
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
    a.filedata_path AS `filedata_path`,
    a.filedata_type AS `filedata_type`,
    a.filedata_size AS `filedata_size`,
    a.time AS `time`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM kms_training a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_modkms"] = "
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
    a.filedata_path AS `filedata_path`,
    a.filedata_type AS `filedata_type`,
    a.filedata_size AS `filedata_size`,
    a.time AS `time`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM kms_training a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE id_training = %d
";
$sql["insert_modkms"] = "
INSERT INTO kms_training
(
    id_training,
    kmstraining_userid,
    judul,
    jenis,
    pembicara,
    lokasi,
    peserta,
    tanggal,
    filedata_enc,
    filedata_origin,
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
    %s,
    %s,
    %s,
    %s
)
";
$sql["update_modkms"] = "
UPDATE kms_training
SET 
    id_training = %s,
    kmstraining_userid = %s,
    judul = %s,
    jenis = %s,
    pembicara = %s,
    lokasi = %s,
    peserta = %s,
    tanggal = %s,
    filedata_enc = %s,
    filedata_origin = %s,
    filedata_path = %s,
    filedata_type = %s,
    filedata_size = %s,
    time = %s
WHERE id_id = %d
";
$sql["delete_modkms"] = "
DELETE FROM kms_training
WHERE id_id = %d
";
$sql["list_modkms"] = "
SELECT
    id_id AS `id`,
    id_name AS `name`
FROM
    kms_training
ORDER BY id_name
";