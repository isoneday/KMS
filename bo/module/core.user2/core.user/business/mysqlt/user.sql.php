<?php

$sql["count_user"] = "
SELECT 
    COUNT(user_id) AS total
FROM gtfw_user
WHERE
    user_id != 0
    --search--";

$sql["get_user"] = "
SELECT 
    user_id AS `id`,
    personal_id AS 'personal_id',
      (SELECT zc.id_photo FROM kms_photo zc WHERE zc.id_photo = u.id_photo) AS id_photo,    
      (SELECT ere.emptype_name FROM emp_ref_employee_type ere WHERE ere.emptype_id = u.user_emptype_id) AS user_emptype_id,    
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
$sql['insert_file_photo'] = "
INSERT INTO `kms_photo`(
     `id_photo`,
     `photo_phototype_id`,
     `photo_file`,
     `photo_origin`,
     `photo_path`,
     `photo_type`,
     `photo_size`,
     `insert_user_id`,
     `insert_timestamp`
)VALUES (
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        NOW()
)  
";
$sql['update_file_photo'] = "
UPDATE `kms_photo`
SET
     `photo_phototype_id` = %s,
     `photo_file` = %s,
     `photo_origin` = %s,
     `photo_path` = %s,
     `photo_type` = %s,
     `photo_size` = %s,
     `update_user_id` = %s,
     `update_timestamp` = NOW()
WHERE photo_id = %d
";
$sql["get_detail_user"] = "
SELECT 
    user_id AS `id`,
        personal_id AS 'personal_id',
        id_photo AS 'id_photo',
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
    
    GROUP_CONCAT(DISTINCT(CAST(CONCAT(g.group_id) AS CHAR))) AS `group`,
    l.lang_name AS lang_name
FROM gtfw_user u
lEFT JOIN gtfw_user_group ug ON ug.usergroup_user_id = u.user_id
LEFT JOIN kms_photo zc ON zc.`id_photo` = u.`user_id` AND zc.`photo_phototype_id` = 1

LEFT JOIN gtfw_group g ON g.group_id = ug.usergroup_group_id
LEFT JOIN gtfw_lang l ON l.lang_code = u.user_active_lang_code
WHERE user_id = %d
";
$sql["insert_user"] = "
INSERT INTO gtfw_user
(
    personal_id,
    id_photo,
    user_emptype_id,
    jenis_kelamin,
    agama,
    tahun_masuk,
    kode_pos,
    tempat_lahir,
    alamat,
    no_hp,
    user_real_name,
    user_user_name,
    user_email,
    user_password,
    user_desc,
    user_active,
    user_force_logout,
    user_active_lang_code,
    insert_user_id,
    insert_timestamp
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
    MD5(%s),
    %s,
    %s,
    %s,
    %s,
    %s,
    NOW()
)
";
$sql["update_user"] = "
UPDATE gtfw_user
SET 
        personal_id =%s,
 id_photo=%s,
    jenis_kelamin =%s,
    agama =%s,
    tahun_masuk =%s,
    kode_pos =%s,
    tempat_lahir =%s,
    alamat =%s,
    no_hp =%s,
    user_real_name = %s,
    user_user_name = %s,
    user_email = %s,
    user_desc = %s,
    user_active = %s,
    user_active_lang_code = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE user_id = %d
";
$sql["delete_user"] = "
DELETE FROM gtfw_user
WHERE user_id = %d
";
$sql['delete_user_group'] = "
DELETE 
FROM
  gtfw_user_group 
WHERE usergroup_user_id = %d
";
$sql['add_user_group'] = "
INSERT INTO gtfw_user_group (
  usergroup_user_id,
  usergroup_group_id
) 
SELECT 
  %s AS user_id,
  g.group_id 
FROM
  gtfw_group g 
WHERE group_id IN (%s)
";

$sql['chek_password_user'] = "
SELECT
	user_id
FROM
	gtfw_user
WHERE
	user_password = MD5(%s) AND user_id = %d
";

$sql['change_password'] = "
UPDATE gtfw_user
SET
    user_password = MD5(%s)
WHERE
    user_id = %d
";

$sql['delete_user_fav_menu'] = "
DELETE FROM gtfw_user_fav_menu
WHERE
	favmenu_user_id = %d
";

$sql['delete_user_group'] = "
DELETE FROM gtfw_user_group
WHERE
	usergroup_user_id = %d
";

$sql['delete_user_new_pass'] = "
DELETE 
FROM
  `gtfw_user_new_pass` 
WHERE `usrnewpass_user_id` = %d
";

$sql['delete_user_unit'] = "
DELETE 
FROM
  `gtfw_user_unit` 
WHERE `userunit_user_id` = %d 
";

$sql['delete_user_whosonline'] = "
DELETE 
FROM
  `gtfw_user_whosonline` 
WHERE `whos_user_id` = %d 
";
$sql['get_user_info'] = "
SELECT
	u.user_id AS user_id,
    u.personal_id AS 'personal_id',
    u.jenis_kelamin AS 'jenis_kelamin',
    u.agama AS 'agama',
    u.tahun_masuk AS 'tahun_masuk',
    u.kode_pos AS 'kode_pos',
    u.tempat_lahir AS 'tempat_lahir',
    u.alamat AS 'alamat',
    u.no_hp AS 'no_hp',
    u.user_real_name AS real_name,
	u.user_password AS `password`,
	u.user_no_password AS no_password,
	u.user_active AS active,
	u.user_force_logout AS force_logout,
	u.user_active_lang_code AS lang_code,
	un.userunit_unit_id AS unit_id,
	g.`group_id` AS group_id,
	g.`group_name` AS group_name,
	IFNULL(e.`emp_name`, u.`user_real_name`) AS name,
	u.`user_email` AS email,
    e.emp_gender AS gender,
	p.`photo_file` AS photo,
	p.`photo_origin` AS photo_ori,
	p.`photo_path` AS photo_path,
	p.`photo_size` AS photo_size,
	p.`photo_type` AS photo_type
FROM
	gtfw_user u
LEFT JOIN gtfw_user_group ug ON u.user_id = ug.usergroup_user_id
LEFT JOIN gtfw_group g ON ug.usergroup_group_id = g.group_id
LEFT JOIN gtfw_user_unit un ON un.userunit_user_id = u.user_id
LEFT JOIN emp_employee_user eu ON eu.`empuser_user_id` = u.`user_id`
LEFT JOIN emp_employee e ON e.`emp_id` = eu.`empuser_emp_id`
LEFT JOIN kms_photo p ON p.`photo_userid` = u.`user_id` AND p.`photo_phototype_id` = 1
WHERE
	u.user_id = '%s'
AND g.group_application_id = '%s'
GROUP BY eu.`empuser_id`, p.`photo_userid`    
";