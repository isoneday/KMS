<?php

$sql["count_modkmsmeeting"] = "
SELECT 
    COUNT(id_meeting) AS total
FROM kms_meeting
";
$sql["get_modkmsmeeting"] = "
SELECT 
SQL_CALC_FOUND_ROWS

    a.id_meeting AS `meeting`,
    b.user_id AS `kmsmeeting_userid`,
    a.topik AS `topik`,
    a.pembicara AS `pembicara`,
    a.agenda AS `agenda`,
    a.jum_peserta AS `jum_peserta`,
    a.waktu AS `waktu`,
    a.tanggal AS `tanggal`,
     a.filedata_origin AS 'filedata_enc',
    a.filedata_txt AS 'filedata_txt', 
    a.filedata_enc AS 'lam_filedata',
    a.filedata_path AS 'filedata_path',
    a.filedata_type AS 'filedata_type',
    a.filedata_size AS 'filedata_size',
   
    (SELECT b.`user_user_name` FROM `gtfw_user` b WHERE b.user_id = a.kmsmeeting_userid) AS uploadby
   
FROM kms_meeting a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`kmsmeeting_userid`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_modkmsmeeting"] = "
SELECT 
    a.id_meeting AS `meeting`,
     a.kmsmeeting_userid AS `kmsmeeting_userid`,
    a.topik AS `topik`,
    a.pembicara AS `pembicara`,
    a.agenda AS `agenda`,
    a.jum_peserta AS `jum_peserta`,
    a.waktu AS `waktu`,
    a.tanggal AS `tanggal`
 FROM kms_meeting a
LEFT JOIN gtfw_user b ON a.`kmsmeeting_userid` = b.`user_id`
WHERE id_meeting = %d
";
$sql["insert_modkmsmeeting"] = "
INSERT INTO kms_meeting
(
    kmsmeeting_userid,
    topik,
    pembicara,
    agenda,
    jum_peserta,
    tanggal,
    filedata_enc,
    filedata_origin,
    filedata_txt,
    filedata_path,
    filedata_type,
    filedata_size,
    waktu
  
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
    NOW()
)
";
$sql["update_modkmsmeeting"] = "
UPDATE kms_meeting
SET 

    topik = %s,
    pembicara = %s,
    agenda = %s,
    jum_peserta = %s,
    tanggal = %s,
    filedata_origin =%s,
    filedata_enc =%s,
     filedata_path = %s,
    filedata_type = %s,
    filedata_size = %s,
    time = %s

WHERE id_meeting = %d
";
$sql["delete_modkmsmeeting"] = "
DELETE FROM kms_meeting
WHERE id_meeting = %d
";
$sql["list_modkmsmeeting"] = "
SELECT
    id_meeting AS `id`,
    id_name AS `name`
FROM
    kms_meeting
ORDER BY id_name
";