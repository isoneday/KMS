<?php


$sql["count_modkmsdata"] = "
SELECT FOUND_ROWS() AS total
";
$sql["count_modkmsdata"] = "
SELECT FOUND_ROWS() AS total
";
$sql["get_modkmsdata"] = "
SELECT 

SQL_CALC_FOUND_ROWS


    a.id_data AS `data`,
    b.user_id AS `kmsdata_userid`,
    (SELECT c.nama_dokumentasi FROM kms_master_type_dokumentasi c WHERE c.id_masdok = a.kmsdata_masdok_id) AS nama_dokumentasi,    
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

WHERE 
1 = 1   
    --search--
--limit--    

   ";

$sql["getOriginFile"]="
    SELECT filedata_enc 
    FROM kms_data WHERE filedata_txt= %s
    AND kmsdata_masdok_id='%d'
";

$sql["get_pagesearch"] = "
SELECT 
DISTINCT

    (SELECT c.id_masdok FROM kms_master_type_dokumentasi c WHERE c.id_masdok = a.kmsdata_masdok_id) AS idmasdok,
    b.user_id AS `kmsdata_userid`,
    (SELECT c.nama_dokumentasi FROM kms_master_type_dokumentasi c WHERE c.id_masdok = a.kmsdata_masdok_id) AS nama_dokumentasi,    
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

WHERE 
1 = 1   
AND id_masdok='%d' 
    --search--
--limit--    

   ";

$sql["get_detail_pagesearch"] = "
SELECT 
    a.faq_id AS `id`,
    a.faq_question AS `question`,
    a.faq_answer AS `answer`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM cms_faq a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE faq_id = %d
";

$sql["get_searchdocument"] = "
SELECT id, filename,time FROM documents WHERE MATCH (contents) AGAINST ('search keywords here' IN NATURAL LANGUAGE MODE)";

$sql["delete_modkmsdata"] = "
DELETE FROM kms_data
WHERE id_data = %d
";
