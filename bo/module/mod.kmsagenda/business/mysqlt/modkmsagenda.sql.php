<?php

$sql["count_modkmsagenda"] = "
SELECT 
    COUNT(id_agenda) AS total
FROM kms_agenda
";
$sql["get_modkmsagenda"] = "
SELECT 
    a.id_agenda AS `agenda`,
    a.id_agenda_user AS `agenda_user`,
    a.judul AS `judul`,
    a.desc AS `desc`,
    a.status AS `status`
    
FROM kms_agenda a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`id_agenda_user`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_modkmsagenda"] = "
SELECT 
    a.id_agenda AS `agenda`,
    a.id_agenda_user AS `agenda_user`,  
    a.status AS `status`,
    a.judul AS `judul`,
    a.desc AS `desc`
FROM kms_agenda a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE id_agenda = %d
";
$sql["insert_modkmsagenda"] = "
INSERT INTO kms_agenda
(   
    id_agenda_user,
    judul,
    desc,
    status,
) VALUES (
    %s,
    %s,
    %s,
    %s
)
";
$sql["update_modkmsagenda"] = "
UPDATE kms_agenda
SET 
    id_agenda = %s,
    status = %s,
    judul = %s,
    desc = %s
WHERE id_id = %d
";
$sql["delete_modkmsagenda"] = "
DELETE FROM kms_agenda
WHERE id_id = %d
";
$sql["list_modkmsagenda"] = "
SELECT
    id_id AS `id`,
    id_name AS `name`
FROM
    kms_agenda
ORDER BY id_name
";