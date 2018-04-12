<?php

$sql["count_modforum"] = "
SELECT 
    COUNT(id_kategori_forum) AS total
FROM kategori_forum
WHERE
    1 = 1
    --search--
";
$sql["get_modforum"] = "
SELECT 
    a.id_kategori_forum AS `kategori_forum`,
    a.kat_forum AS `kat_forum`,
    a.kat_userid AS `kat_userid`
    
FROM kategori_forum a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`kat_userid`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_modforum"] = "
SELECT 
    a.id_kategori_forum AS `kategori_forum`,
    a.kat_forum AS `kat_forum`,
    a.kat_userid AS `kat_userid`

FROM kategori_forum a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`kat_userid`
WHERE id_kategori_forum = %d
";
$sql["insert_modforum"] = "
INSERT INTO kategori_forum
(
    kat_forum,
    kat_userid
) VALUES (
    %s,
    %s
)
";
$sql["update_modforum"] = "
UPDATE kategori_forum
SET 
    id_kategori_forum = %s,
    kat_forum = %s,
    kat_userid = %s
WHERE id_id = %d
";
$sql["delete_modforum"] = "
DELETE FROM kategori_forum
WHERE id_kategori_forum = %d
";
$sql["list_modforum"] = "
SELECT
    id_id AS `id`,
    id_name AS `name`
FROM
    kategori_forum
ORDER BY id_name
";