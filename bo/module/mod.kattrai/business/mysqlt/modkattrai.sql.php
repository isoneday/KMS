<?php

$sql["count_modkattrai"] = "
SELECT 
    COUNT(id_kat) AS total
FROM kms_kat_training
WHERE
    1 = 1
    --search--
";
$sql["get_modkattrai"] = "
SELECT 
    a.id_kat AS `kat`,
    a.id_kat_user AS `kat_user`,
    a.kategori AS `kategori`,
    a.desc AS `desc`

FROM kms_kat_training a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`id_kat_user`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_modkattrai"] = "
SELECT 
    a.id_kat AS `kat`,
    a.id_kat_user AS `kat_user`,
    a.kategori AS `kategori`,
    a.desc AS `desc`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM kms_kat_training a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE id_kat = %d
";
$sql["insert_modkattrai"] = "
INSERT INTO kms_kat_training
(
    id_kat,
    id_kat_user,
    kategori,
    desc
) VALUES (
    %s,
    %s,
    %s,
    %s
)
";
$sql["update_modkattrai"] = "
UPDATE kms_kat_training
SET 
    id_kat = %s,
    id_kat_user = %s,
    kategori = %s,
    desc = %s
WHERE id_id = %d
";
$sql["delete_modkattrai"] = "
DELETE FROM kms_kat_training
WHERE id_id = %d
";
$sql["list_modkattrai"] = "
SELECT
    id_id AS `id`,
    id_name AS `name`
FROM
    kms_kat_training
ORDER BY id_name
";