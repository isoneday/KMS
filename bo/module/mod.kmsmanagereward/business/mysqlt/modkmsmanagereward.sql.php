<?php

$sql["count_modkmsmanagereward"] = "
SELECT 
    COUNT(id_reward) AS total
FROM kms_reward
WHERE
    1 = 1
    --search--
";
$sql["get_modkmsmanagereward"] = "
SELECT 
    a.id_reward AS `reward`,
    a.id_user AS `user`,
    a.nama_reward AS `nama_reward`,
    a.keterangan AS `keterangan`

FROM kms_reward a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`id_user`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_modkmsmanagereward"] = "
SELECT 
    a.id_reward AS `reward`,
    a.id_user AS `user`,
    a.nama_reward AS `nama_reward`,
    a.keterangan AS `keterangan`

FROM kms_reward a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`id_user`
WHERE id_reward = %d
";
$sql["insert_modkmsmanagereward"] = "
INSERT INTO kms_reward
(
    id_user,
    nama_reward,
    keterangan
) VALUES (
    %s,
    %s,
    %s
)
";
$sql["update_modkmsmanagereward"] = "
UPDATE kms_reward
SET 
    id_user = %s,
    nama_reward = %s,
    keterangan = %s
WHERE id_reward = %d
";
$sql["delete_modkmsmanagereward"] = "
DELETE FROM kms_reward
WHERE id_reward = %d
";
$sql["list_modkmsmanagereward"] = "
SELECT
    id_reward AS `id`,
    id_name AS `name`
FROM
    kms_reward
ORDER BY id_name
";