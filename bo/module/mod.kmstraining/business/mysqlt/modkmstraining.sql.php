<?php

$sql["count_modkmstraining"] = "
SELECT 
    COUNT(id_training) AS total
FROM kms_training
";
$sql["get_modkmstraining"] = "
SELECT 
SQL_CALC_FOUND_ROWS

    a.id_training AS `training`,
    a.kmstraining_userid AS `kmstraining_userid`,
    a.judul AS `judul`,
    a.jenis AS `jenis`,
    a.pembicara AS `pembicara`,
    a.lokasi AS `lokasi`,
    a.peserta AS `peserta`,
    a.tanggal AS `tanggal`,
    a.filedata_origin AS 'filedata_enc',
    a.filedata_txt AS 'filedata_txt', 
    a.filedata_enc AS 'lam_filedata',
    a.filedata_path AS 'filedata_path',
    a.filedata_type AS 'filedata_type',
    a.filedata_size AS 'filedata_size',
   a.time AS `time`,
       (SELECT b.`user_user_name` FROM `gtfw_user` b WHERE b.user_id = a.kmstraining_userid) AS uploadby
 

FROM kms_training a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`kmstraining_userid`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_modkmstraining"] = "
SELECT 
    a.id_training AS `training`,
    a.kmstraining_userid AS `kmstraining_userid`,
    a.judul AS `judul`,
    a.jenis AS `jenis`,
    a.pembicara AS `pembicara`,
    a.lokasi AS `lokasi`,
    a.peserta AS `peserta`,
    a.tanggal AS `tanggal`,
    a.time AS `time`
   FROM kms_training a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`kmstraining_userid`
WHERE id_training = %d
";
$sql["insert_modkmstraining"] = "
INSERT INTO kms_training
(
    kmstraining_userid,
    judul,
    jenis,
    pembicara,
    lokasi,
    peserta,
    tanggal,
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
    NOW()
)
";
$sql["update_modkmstraining"] = "
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
    filedata_txt = %s,
    filedata_path = %s,
    filedata_type = %s,
    filedata_size = %s,
  time = %s
WHERE id_training = %d
";
$sql["delete_modkmstraining"] = "
DELETE FROM kms_training
WHERE id_training = %d
";
$sql["list_modkmstraining"] = "
SELECT
    id_training AS `id`,
    id_name AS `name`
FROM
    kms_training
ORDER BY id_name
";