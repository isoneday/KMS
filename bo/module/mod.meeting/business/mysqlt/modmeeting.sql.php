<?php

$sql["count_modmeeting"] = "
SELECT 
    COUNT(id_meeting) AS total
FROM kms_meeting
WHERE
    1 = 1
    --search--
";
$sql["get_modmeeting"] = "
SELECT 
    a.id_meeting AS `meeting`,
    a.kmsmeeting_userid AS `kmsmeeting_userid`,
    a.topik AS `topik`,
    a.pembicara AS `pembicara`,
    a.agenda AS `agenda`,
    a.jum_peserta AS `jum_peserta`,
    a.waktu AS `waktu`,
    a.tanggal AS `tanggal`,
    a.status_agenda AS `status_agenda`,
    a.filedata_enc AS `filedata_enc`,
    a.filedata_origin AS `filedata_origin`,
    a.filedata_txt AS `filedata_txt`,
    a.filedata_path AS `filedata_path`,
    a.filedata_type AS `filedata_type`,
    a.filedata_size AS `filedata_size`,
    (SELECT b.`user_user_name` FROM `gtfw_user` b WHERE b.user_id = a.kmsmeeting_userid) AS uploadby
    
FROM kms_meeting a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`kmsmeeting_userid`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_modmeeting"] = "
SELECT 
    a.id_meeting AS `meeting`,
    a.kmsmeeting_userid AS `kmsmeeting_userid`,
    a.topik AS `topik`,
    a.pembicara AS `pembicara`,
    a.agenda AS `agenda`,
    a.jum_peserta AS `jum_peserta`,
    a.waktu AS `waktu`,
    a.tanggal AS `tanggal`,
    a.status_agenda AS `status_agenda`,
    a.filedata_enc AS `filedata_enc`,
    a.filedata_origin AS `filedata_origin`,
    a.filedata_txt AS `filedata_txt`,
    a.filedata_path AS `filedata_path`,
    a.filedata_type AS `filedata_type`,
    a.filedata_size AS `filedata_size`
FROM kms_meeting a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`kmsmeeting_userid`
WHERE id_meeting = %d
";
$sql["list_modmeeting"] = "
SELECT
    id_id AS `id`,
    id_name AS `name`
FROM
    kms_meeting
ORDER BY id_name
";