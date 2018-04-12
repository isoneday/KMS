<?php

$sql["count_modkmsdata"] = "
SELECT count(id_data) as total from kms_data 
";
$sql["get_modkmsdata"] = "
SELECT 

SQL_CALC_FOUND_ROWS


    a.id_data AS `data`,
    b.user_id AS `kmsdata_userid`,
 (SELECT c.nama_dokumentasi FROM kms_master_type_dokumentasi c WHERE c.id_masdok = a.kmsdata_masdok_id) AS idmasdok,     
    a.kmsdata_keyword AS `kmsdata_keyword`,
    a.filedata_origin AS 'filedata_enc',
    a.filedata_txt AS 'filedata_txt', 
    a.filedata_enc AS 'lam_filedata',
    a.filedata_path AS 'filedata_path',
    a.filedata_type AS 'filedata_type',
    a.filedata_size AS 'filedata_size',
    (SELECT b.`user_user_name` FROM `gtfw_user` b WHERE b.user_id = a.kmsdata_userid) AS uploadby,
    a.time AS 'time'
            

   

   FROM kms_data a
LEFT JOIN gtfw_user b ON b.user_id =a.kmsdata_userid 
LEFT JOIN kms_master_type_dokumentasi c ON c.id_masdok= a.kmsdata_masdok_id 
LEFT JOIN kms_group_master_dokumentasi d ON d.kms_group_iddok= a.id_data and d.kms_group_id_masdok= c.id_masdok


WHERE 
1 = 1   
    --search--
--limit--    

   ";

//LEFT JOIN kms_dokumen b ON b.`id_kmsdokumen`=a.`kmsdata_id_kmsdokumen`";
$sql["get_detail_modkmsdata"] = "
SELECT 
    a.id_data AS `data`,
    a.kmsdata_userid AS `kmsdata_userid`,
 (SELECT c.nama_dokumentasi FROM kms_master_type_dokumentasi c WHERE c.id_masdok = a.kmsdata_masdok_id) AS nama_dokumentasi,     
    a.kmsdata_keyword AS `kmsdata_keyword`
FROM kms_data a
LEFT JOIN gtfw_user b ON a.kmsdata_userid= b.user_id
LEFT JOIN kms_master_type_dokumentasi c ON c.id_masdok= a.kmsdata_masdok_id 
WHERE id_data = %d
";
$sql["insert_modkmsdata"] = "
INSERT INTO kms_data
(   
    kmsdata_userid,
    kmsdata_masdok_id,
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
    NOW()
)";

$sql['get_foto']="

SELECT

    a.filedata_origin AS FILE,
    a.filedata_enc AS enc,
    a.filedata_path AS path,
    a.filedata_type AS type,
    a.filedata_size AS size
FROM kms_data a
LEFT JOIN gtfw_user b ON a.kmsdata_userid= b.user_id
WHERE id_data = %d
";

$sql['getNameFileById']="
   SELECT filedata_txt AS name_file
   FROM kms_data WHERE id_data  %d
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