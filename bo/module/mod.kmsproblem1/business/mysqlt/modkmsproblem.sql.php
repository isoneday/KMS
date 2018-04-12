<?php

$sql["count_modkmsproblem"] = "
SELECT 
    COUNT(id_problem) AS total
FROM kms_logproblem
";
$sql["get_modkmsproblem"] = "
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
$sql["get_detail_modkmsproblem"] = "
SELECT 
    a.id_problem AS `id_problem`,
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
LEFT JOIN gtfw_user b ON b.`user_id` = a.`id_user_problem`
WHERE id_problem = %d
";
$sql["insert_modkmsproblem"] = "
INSERT INTO kms_logproblem
(
    id_user_problem,
    problemm,
    person_request,
    person_solving,
    PIC,
    status,
    catatan,
    filedata_enc,
     filedata_origin,
    filedata_path,
    filedata_type,
    filedata_size,
    filedata_enc2,
  filedata_origin2,
    filedata_path2,
    filedata_type2,
    filedata_size2,
    filedata_enc3,
    filedata_origin3,
    filedata_path3,
    filedata_type3,
    filedata_size3
    ) 
VALUES (
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
    %s,
    %s
     )
";
$sql["update_modkmsproblem"] = "
UPDATE kms_logproblem
SET 
    problemm = %s,
    person_request = %s,
    person_solving = %s,
    PIC = %s,
    status = %s,
    catatan = %s,
    filedata_enc = %s,
    filedata_origin = %s,
    filedata_path = %s,
    filedata_type = %s,
    filedata_size = %d,
    filedata_enc2 = %s,
    filedata_origin2 = %s,
    filedata_path2 = %s,
    filedata_type2 = %s,
    filedata_size2 = %d,
    filedata_enc3 = %s,
    filedata_origin3 = %s,
    filedata_path3 = %s,
    filedata_type3 = %s,
    filedata_size3 = %d

  
    WHERE id_problem = %d
";
$sql["delete_modkmsproblem"] = "
DELETE FROM kms_logproblem
WHERE id_problem = %d
";
$sql["list_modkmsproblem"] = "
SELECT
    id_problem AS `id`,
    id_name AS `name`
FROM
    kms_logproblem
ORDER BY id_name
";

$sql['get_foto']="

SELECT

    a.filedata_origin AS FILE,
    a.filedata_enc AS enc,
    a.filedata_path AS path,
    a.filedata_type AS type,
    a.filedata_size AS size
FROM kms_logproblem a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`id_user_problem`
WHERE id_problem = %d
";
$sql['get_foto2']="

SELECT

    a.filedata_origin2 AS FILE2,
    a.filedata_enc2 AS enc2,
    a.filedata_path2 AS path2,
    a.filedata_type2 AS type2,
    a.filedata_size2 AS size2
FROM kms_logproblem a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`id_user_problem`
WHERE id_problem = %d
";
$sql['get_foto3']="

SELECT

    a.filedata_origin3 AS FILE3,
    a.filedata_enc3 AS enc3,
    a.filedata_path3 AS path3,
    a.filedata_type3 AS type3,
    a.filedata_size3 AS size3
FROM kms_logproblem a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`id_user_problem`
WHERE id_problem = %d
";

