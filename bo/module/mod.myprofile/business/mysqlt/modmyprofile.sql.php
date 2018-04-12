<?php

$sql["count_modmyprofile"] = "
SELECT 
    COUNT(user_id) AS total
FROM gtfw_user
";
$sql["get_modmyprofile"] = "
SELECT 
  SQL_CALC_FOUND_ROWS

    a.user_id AS `id`,
    a.personal_id AS `personal_id`,
    a.jenis_kelamin AS `jenis_kelamin`,
    a.agama AS `agama`,
    a.posisi_kerja AS 'posisi_kerja',
    a.tahun_masuk AS `tahun_masuk`,
    a.kode_pos AS `kode_pos`,
    a.tempat_lahir AS `tempat_lahir`,
    a.alamat AS `alamat`,
    a.no_hp AS `no_hp`,
    a.user_real_name AS `real_name`,
    a.user_user_name AS `name`,
    a.user_email AS `email`,
    a.user_password AS `password`,
    a.user_desc AS `desc`,
    a.user_no_password AS `no_password`,
    a.user_active AS `active`,
    a.user_force_logout AS `force_logout`,
    a.user_active_lang_code AS `active_lang_code`,
    a.user_last_logged_in AS `last_logged_in`,
    a.user_last_ip AS `last_ip`,
    a.insert_user_id AS `insert_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_id`,
    (SELECT zc.photo_path FROM kms_photo zc WHERE zc.photo_userid = a.user_id) AS `filephoto`,     
    a.update_timestamp AS `update_timestamp`
FROM gtfw_user a
lEFT JOIN gtfw_user_group ug ON ug.usergroup_user_id = a.user_id
LEFT JOIN gtfw_group g ON g.group_id = ug.usergroup_group_id
LEFT JOIN kms_photo zc ON zc.`id_photo` = a.`user_id` 

WHERE user_user_name = %s 

";
$sql["get_detail_modmyprofile"] = "
SELECT 
    a.user_id AS `id`,
    a.personal_id AS `personal_id`,
    a.jenis_kelamin AS `jenis_kelamin`,
    a.agama AS `agama`,
    a.posisi_kerja AS 'posisi_kerja',
    a.tahun_masuk AS `tahun_masuk`,
    a.kode_pos AS `kode_pos`,
    a.tempat_lahir AS `tempat_lahir`,
    a.alamat AS `alamat`,
    a.no_hp AS `no_hp`,
    a.user_real_name AS `real_name`,
    a.user_user_name AS `name`,
    a.user_email AS `email`,
    a.user_password AS `password`,
    a.user_desc AS `desc`,
    a.user_no_password AS `no_password`,
    a.user_active AS `active`,
    a.user_force_logout AS `force_logout`,
    a.user_active_lang_code AS `active_lang_code`,
    a.user_last_logged_in AS `last_logged_in`,
    a.user_last_ip AS `last_ip`,
    a.insert_user_id AS `insert_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_id`,
    a.update_timestamp AS `update_timestamp`
FROM gtfw_user a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE user_id = %d
";
$sql['get_foto']="

SELECT
         zc.`id_photo` AS id_photo,
        zc.`photo_file` AS photo,
    zc.`photo_origin` AS photo_origin,
    zc.`photo_path` AS filephoto,
    zc.`photo_type` AS photo_type,
    zc.`photo_size` AS photo_size
FROM kms_photo zc
LEFT JOIN gtfw_user b ON a.kmsdata_userid= b.user_id

WHERE id_data = %d
";
