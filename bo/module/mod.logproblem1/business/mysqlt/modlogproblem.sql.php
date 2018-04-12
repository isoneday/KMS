<?php

$sql["count_modlogproblem"] = "
SELECT 
    COUNT(id_problem) AS total
FROM kms_logproblem
";
$sql["get_modlogproblem"] = "
SELECT 
    a.id_problem AS `id_problem`,
    b.user_id AS `id_user_problem`,
    a.problemm AS `problemm`,
    a.person_request AS `person_request`,
    a.person_solving AS `person_solving`,
    a.PIC AS `PIC`,
    a.status AS `status`,
    a.catatan as `catatan`,
    
    a.filedata_origin AS 'filedata_enc',
    a.filedata_origin2 AS 'filedata_enc2',    
    a.filedata_origin3 AS 'filedata_enc3',    
    a.filedata_enc AS 'lam_filedata',
    a.filedata_path AS 'filedata_path',
    a.filedata_type AS 'filedata_type',
    a.filedata_size AS 'filedata_size',
    a.filedata_enc2 AS 'lam_filedata2',
    a.filedata_path2 AS 'filedata_path2',
    a.filedata_type2 AS 'filedata_type2',
    a.filedata_size2 AS 'filedata_size2',
    a.filedata_enc3 AS 'lam_filedata3',
    a.filedata_path3 AS 'filedata_path3',
    a.filedata_type3 AS 'filedata_type3',
    a.filedata_size3 AS 'filedata_size3'
    
FROM kms_logproblem a
LEFT JOIN gtfw_user b ON a.`id_user_problem` = b.`user_id` 
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_modlogproblem"] = "
SELECT 
    a.id_problem AS `problem`,
    a.id_user_problem AS `user_problem`,
    a.problemm AS `problemm`,
    a.person_request AS `person_request`,
    a.person_solving AS `person_solving`,
    a.PIC AS `PIC`,
    a.status AS `status`,
    a.catatan AS `catatan`,
    a.attachment AS `attachment`,
    a.filedata_enc AS `filedata_enc`,
    a.filedata_origin AS `filedata_origin`,
    a.filedata_origin2 AS `filedata_origin2`,
    a.filedata_path AS `filedata_path`,
    a.filedata_type AS `filedata_type`,
    a.filedata_size AS `filedata_size`,
    a.filedata_enc2 AS `filedata_enc2`,
    a.filedata_path2 AS `filedata_path2`,
    a.filedata_type2 AS `filedata_type2`,
    a.filedata_size2 AS `filedata_size2`,
    a.filedata_origin3 AS `filedata_origin3`,
    a.filedata_enc3 AS `filedata_enc3`,
    a.filedata_path3 AS `filedata_path3`,
    a.filedata_type3 AS `filedata_type3`,
    a.filedata_size3 AS `filedata_size3`
  FROM kms_logproblem a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`id_user_problem`
WHERE id_problem = %d
";
$sql["list_modlogproblem"] = "
SELECT
    id_id AS `id`,
    id_name AS `name`
FROM
    kms_logproblem
ORDER BY id_name
";