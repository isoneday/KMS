<!-- LEFT JOIN kms_master_type_dokumentasi c ON c.id_masdok= a.kmsdata_masdok_id 
LEFT JOIN kms_group_master_dokumentasi d ON d.kms_group_iddok= a.id_data and d.kms_group_id_masdok= c.id_masdok
 -->
<?php

$sql["count_modkmsdata"] = "
SELECT count(id_data) as total from kms_data 
";
$sql["get_modkmsdata"] = "
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
LEFT JOIN kms_master_type_dokumentasi c ON c.id_masdok= d.kms_group_id_masdok 

WHERE 
1=1
    --search--
--limit-- 
   ";

//LEFT JOIN kms_dokumen b ON b.`id_kmsdokumen`=a.`kmsdata_id_kmsdokumen`";
$sql["get_detail_modkmsdata"] = "
SELECT 
    a.id_data AS `data`,
    a.kmsdata_userid AS `kmsdata_userid`,
 (SELECT c.id_masdok FROM kms_master_type_dokumentasi c WHERE c.id_masdok = a.kmsdata_masdok_id) AS idmasdok,     
    a.kmsdata_keyword AS `kmsdata_keyword`,
    GROUP_CONCAT(DISTINCT(CAST(CONCAT(c.id_masdok,'|',c.nama_dokumentasi) AS CHAR))) AS `group`
    

FROM kms_data a
LEFT JOIN gtfw_user b ON b.user_id =a.kmsdata_userid 
LEFT JOIN kms_group_master_dokumentasi d ON d.kms_group_iddok= a.id_data 
LEFT JOIN kms_master_type_dokumentasi c ON c.id_masdok= d.kms_group_id_masdok 
WHERE id_data = %d
";
$sql["insert_modkmsdata"] = "
INSERT INTO kms_data
(   kmsdata_userid,
    kmsdata_masdok_id,
    kmsdata_keyword,
    jenis,
    pembicara,
    lokasi,
    tanggal,
    topik,
    agenda,
    nama_produk,
    jenis_produk,
    bidang_produk,
    keterangan,
    status,
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
)";

$sql['add_dok_group'] = "
INSERT INTO kms_group_master_dokumentasi (
  kms_group_iddok,
  kms_group_id_masdok
)
SELECT 
  %s AS id_data,
  c.id_masdok 
FROM
  kms_master_type_dokumentasi c 
WHERE id_masdok IN (%s)
";


$sql['get_foto']="

SELECT
    a.filedata_origin AS FILE,
    a.filedata_enc AS enc,
    a.filedata_path AS path,
    a.filedata_txt AS txt,
    a.filedata_type AS type,
    a.filedata_size AS size
FROM kms_data a
LEFT JOIN gtfw_user b ON a.kmsdata_userid= b.user_id
WHERE id_data = %d
";

$sql['getNameFileById']="
   SELECT filedata_txt AS name_file
   FROM kms_data WHERE id_data = %d
";
$sql['getNameFileById2']="
   SELECT filedata_enc AS name_file2
   FROM kms_data WHERE id_data = %d
";


$sql["update_modkmsdata"] = "
UPDATE kms_data
SET 

    kmsdata_keyword = %s,
    kmsdata_masdok_id=%s,
    filedata_origin=%s,
    filedata_enc =%s
    
WHERE id_data = %d
";
$sql["delete_modkmsdata"] = "
DELETE FROM kms_data
WHERE id_data = %d
";



$sql["list_modkmsdata"] = "
SELECT
    id_masdok AS `id`,
    nama_dokumentasi AS `name`
FROM
    kms_master_type_dokumentasi
ORDER BY nama_dokumentasi
";