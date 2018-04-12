<?php

$sql["count_modprofilekaryawan"] = "
SELECT 
    COUNT(user_id) AS total
FROM gtfw_user
WHERE
    1 = 1
    --search--
";
$sql["get_modprofilekaryawan"] = "
SELECT 
    user_id AS `id`,
    personal_id AS 'personal_id',
      (SELECT zc.id_photo FROM kms_photo zc WHERE zc.photo_userid = u.user_id) AS id_photo,    
      (SELECT g.group_name FROM gtfw_group g WHERE g.group_id = ug.usergroup_group_id) AS group_name,    
    jenis_kelamin AS 'jenis_kelamin',
    agama AS 'agama',
    posisi_kerja AS 'posisi_kerja',
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
LEFT JOIN kms_photo zc ON zc.`photo_userid` = u.`user_id`
 AND zc.`photo_phototype_id` = 1

WHERE
    user_id != 0
    --search--
GROUP BY u.user_id 
--limit--    
";
$sql["get_detail_modprofilekaryawan"] = "
SELECT 
    user_id AS `id`,
        personal_id AS 'personal_id',
    jenis_kelamin AS 'jenis_kelamin',
    agama AS 'agama',
    posisi_kerja AS 'posisi_kerja',
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
    
    GROUP_CONCAT(DISTINCT(CAST(CONCAT(g.group_id) AS CHAR))) AS `group`,
    l.lang_name AS lang_name
FROM gtfw_user u
lEFT JOIN gtfw_user_group ug ON ug.usergroup_user_id = u.user_id
LEFT JOIN kms_photo zc ON zc.`photo_userid` = u.`user_id` AND zc.`photo_phototype_id` = 1

LEFT JOIN gtfw_group g ON g.group_id = ug.usergroup_group_id
LEFT JOIN gtfw_lang l ON l.lang_code = u.user_active_lang_code
WHERE user_id = %d
";
$sql["list_modprofilekaryawan"] = "
SELECT
    user_id AS `id`,
    user_name AS `name`
FROM
    gtfw_user
ORDER BY user_name
";