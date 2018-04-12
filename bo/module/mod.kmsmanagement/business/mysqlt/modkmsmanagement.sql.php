<?php

$sql["count_modkmsmanagement"] = "
SELECT 
    COUNT(id_data) AS total
FROM kms_data
WHERE
    1 = 1
    --search--
";
$sql["get_modkmsmanagement"] = "
SELECT 
    a.id_data AS `data`,
    a.kmsdata_userid AS `kmsdata_userid`,
    a.kmsdata_masdok_id AS `kmsdata_masdok_id`,
    a.kmsdata_keyword AS `kmsdata_keyword`,
    a.filedata_enc AS `filedata_enc`,
    a.filedata_origin AS `filedata_origin`,
    a.filedata_txt AS `filedata_txt`,
    a.filedata_path AS `filedata_path`,
    a.filedata_type AS `filedata_type`,
    a.filedata_size AS `filedata_size`,
    a.time AS `time`,
    a.pembicara AS `pembicara`,
    a.agenda AS `agenda`,
    a.jum_peserta AS `jum_peserta`,
    a.tanggal AS `tanggal`,
    a.status AS `status`,
    a.jenis AS `jenis`,
    a.lokasi AS `lokasi`,
    a.topik AS `topik`,
    a.nama_produk AS `nama_produk`,
    a.jenis_produk AS `jenis_produk`,
    a.bidang_produk AS `bidang_produk`,
    a.keterangan AS `keterangan`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM kms_data a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_modkmsmanagement"] = "
SELECT 
    a.id_data AS `data`,
    a.kmsdata_userid AS `kmsdata_userid`,
    a.kmsdata_masdok_id AS `kmsdata_masdok_id`,
    a.kmsdata_keyword AS `kmsdata_keyword`,
    a.filedata_enc AS `filedata_enc`,
    a.filedata_origin AS `filedata_origin`,
    a.filedata_txt AS `filedata_txt`,
    a.filedata_path AS `filedata_path`,
    a.filedata_type AS `filedata_type`,
    a.filedata_size AS `filedata_size`,
    a.time AS `time`,
    a.pembicara AS `pembicara`,
    a.agenda AS `agenda`,
    a.jum_peserta AS `jum_peserta`,
    a.tanggal AS `tanggal`,
    a.status AS `status`,
    a.jenis AS `jenis`,
    a.lokasi AS `lokasi`,
    a.topik AS `topik`,
    a.nama_produk AS `nama_produk`,
    a.jenis_produk AS `jenis_produk`,
    a.bidang_produk AS `bidang_produk`,
    a.keterangan AS `keterangan`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM kms_data a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE id_data = %d
";
$sql["list_modkmsmanagement"] = "
SELECT
    id_id AS `id`,
    id_name AS `name`
FROM
    kms_data
ORDER BY id_name
";