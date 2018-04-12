<?php

$sql["count_modlistsearching"] = "
SELECT FOUND_ROWS() AS total
";
$sql["get_modlistsearching"] = "
SELECT 
SQL_CALC_FOUND_ROWS

    a.id_data AS `data`,
    b.user_id AS `kmsdata_userid`,
    (SELECT c.nama_dokumentasi FROM kms_master_type_dokumentasi c WHERE c.id_masdok = a.kmsdata_masdok_id) AS `kmsdata_masdok_id`,     
    (SELECT c.id_masdok FROM kms_master_type_dokumentasi c WHERE c.id_masdok = a.kmsdata_masdok_id) AS `idmasdok`,        
    a.kmsdata_keyword AS `kmsdata_keyword`,
    a.jenis AS `jenis`,
    a.pembicara AS `pembicara`,
    a.lokasi AS `lokasi`,
    a.tanggal AS `tanggal`,
    a.topik AS `topik`,
    a.agenda AS `agenda`,
    a.nama_produk AS `nama_produk`,
    a.jenis_produk AS `jenis_produk`,
    a.bidang_produk AS `bidang_produk`,
    a.keterangan AS `keterangan`,
    a.status AS `status`,
    a.filedata_origin AS `filedata_enc`,
    a.filedata_txt AS `filedata_txt`, 
    a.filedata_enc AS `lam_filedata`,
    a.filedata_path AS `filedata_path`,
    a.filedata_type AS `filedata_type`,
    a.filedata_size AS `filedata_size`,
    (SELECT b.`user_user_name` FROM `gtfw_user` b WHERE b.user_id = a.kmsdata_userid) AS `uploadby`,
    a.time AS `time`
        
   FROM kms_data a
LEFT JOIN gtfw_user b ON b.user_id =a.kmsdata_userid 
LEFT JOIN kms_group_master_dokumentasi d ON d.kms_group_iddok= a.id_data 
LEFT JOIN kms_master_type_dokumentasi c ON c.id_masdok= a.kmsdata_masdok_id 

WHERE 
1 = 1   
AND id_masdok='%d' 
--search--
--limit--    
   ";
$sql["getOriginFile"]="
    SELECT filedata_enc 
    FROM kms_data WHERE filedata_txt= %s
";

$sql["get_detail_modlistsearching"] = "
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
    a.time AS `time`
FROM kms_data a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE id_data = %d
";
$sql["list_modlistsearching"] = "
SELECT
    id_id AS `id`,
    id_name AS `name`
FROM
    kms_data
ORDER BY id_name
";