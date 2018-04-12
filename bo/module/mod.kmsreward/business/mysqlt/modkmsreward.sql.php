<?php

$sql["count_modkmsreward"] = "
SELECT 
    COUNT(id_reward) AS total
FROM kms_reward
WHERE
    1 = 1
    --search--
";
$sql["get_user"] = "
SELECT 
    user_id AS `id`,
    personal_id AS 'personal_id',
      (SELECT zc.id_photo FROM kms_photo zc WHERE zc.id_photo = u.id_photo) AS id_photo,    
    jenis_kelamin AS 'jenis_kelamin',
    agama AS 'agama',
    tahun_masuk AS 'tahun_masuk',
    kode_pos AS 'kode_pos',
    tempat_lahir AS 'tempat_lahir',
    alamat AS 'alamat',
    no_hp AS 'no_hp',
    user_real_name AS `real_name`,  
    user_user_name AS `name`,
      user_email AS `email`,
    user_password AS `password`,
    user_desc AS `desc`,
    user_no_password AS `no_password`,
    user_active AS `active`, 
    user_force_logout AS `force_logout`,
    user_active_lang_code AS `active_lang_code`,
    user_last_logged_in AS `last_logged_in`,
    user_last_ip AS `last_ip`,
    u.insert_user_id AS `insert_id`,
    u.insert_timestamp AS `insert_timestamp`,
    u.update_user_id AS `update_id`,
    u.update_timestamp AS `update_timestamp`,
        zc.`id_photo` AS id_photo,
        zc.`photo_file` AS photo,
    zc.`photo_origin` AS photo_origin,
    zc.`photo_path` AS photo_path,
    zc.`photo_type` AS photo_type,
    zc.`photo_size` AS photo_size,
    GROUP_CONCAT(DISTINCT(CAST(CONCAT(g.group_id,'|',g.group_name) AS CHAR))) AS `group`
FROM gtfw_user u
lEFT JOIN gtfw_user_group ug ON ug.usergroup_user_id = u.user_id
LEFT JOIN gtfw_group g ON g.group_id = ug.usergroup_group_id
LEFT JOIN kms_photo zc ON zc.`id_photo` = u.`id_photo` AND zc.`photo_phototype_id` = 1
LEFT JOIN emp_ref_employee_type ere ON ere.`emptype_id` = u.`user_emptype_id`

WHERE
    user_id != 0
    --search--
GROUP BY u.user_id 
--limit--    
";

$sql["get_modkmsreward"] = "
SELECT 
    a.id_reward AS `reward`,
    a.id_user AS `user`,
    a.nama_reward AS `nama_reward`,
    a.keterangan AS `keterangan`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM kms_reward a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_modkmsreward"] = "
SELECT 
    a.id_reward AS `reward`,
    a.id_user AS `user`,
    a.nama_reward AS `nama_reward`,
    a.keterangan AS `keterangan`
FROM kms_reward a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE id_reward = %d
";
$sql["insert_modkmsreward"] = "
INSERT INTO kms_reward
(
    id_reward,
    id_user,
    nama_reward,
    keterangan
) VALUES (
    %s,
    %s,
    %s,
    %s
)
";
$sql["update_modkmsreward"] = "
UPDATE kms_reward
SET 
    id_reward = %s,
    id_user = %s,
    nama_reward = %s,
    keterangan = %s
WHERE id_id = %d
";
$sql["delete_modkmsreward"] = "
DELETE FROM kms_reward
WHERE id_id = %d
";
$sql["list_modkmsreward"] = "
SELECT
    id_id AS `id`,
    id_name AS `name`
FROM
    kms_reward
ORDER BY id_name
";