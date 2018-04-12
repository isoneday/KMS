<?php

$sql['get_default_lang'] = "
SELECT
  `setting_id` AS `id`,
  `setting_name` AS `name`,
  `setting_value` AS `value`
FROM `gtfw_setting`
WHERE setting_name = %d    
";
$sql["count_coregroupall"] = "
SELECT FOUND_ROWS() AS total
";
$sql["get_coregroupall"] = "
SELECT SQL_CALC_FOUND_ROWS
    a.group_id AS `id`,
    a.group_name AS `name`,
    a.group_name AS `group_name`,
    a.group_desc AS `desc`,
    a.group_application_id AS `application_id`,
    a.group_application_id AS `unitappid`,
    c.`application_name` AS application_name,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM gtfw_group a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
INNER JOIN gtfw_application c ON c.`application_id` = a.`group_application_id`
WHERE
    c.`application_status` = 1
    AND 1 = 1
    --search--
--limit--    
";
$sql["get_detail_coregroupall"] = "
SELECT 
    a.group_id AS `id`,
    a.group_name AS `name`,
    a.group_desc AS `desc`,
    a.group_application_id AS `application_id`,
    c.`application_name` AS application_name,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM gtfw_group a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
LEFT JOIN gtfw_application c ON c.`application_id` = a.`group_application_id`
WHERE group_id = %d
";
$sql["insert_coregroupall"] = "
INSERT INTO gtfw_group
(
    group_name,
    group_desc,
    group_application_id,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    %s,
    %s,
    NOW()
)
";
$sql["update_coregroupall"] = "
UPDATE gtfw_group
SET 
    group_name = %s,
    group_desc = %s,
    group_application_id = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE group_id = %d
";
$sql["delete_coregroupall"] = "
DELETE FROM gtfw_group
WHERE group_id = %d
";
$sql['list_application'] = "
SELECT
  a.`application_id` AS id,
  a.`application_name` AS `name`
FROM `gtfw_application` a
WHERE 
   a.application_status = 1 
   and a.`application_id` in (
   select 	
	b.`group_application_id`
   from gtfw_group b
   )
";
$sql['get_access_group'] = "
SELECT
	gm.`groupmenu_menu_id` AS menu_id,
	CAST(GROUP_CONCAT(DISTINCT(md.`module_action_id`)) AS CHAR) AS actions
FROM (
	SELECT
		%d AS group_id
) r
INNER JOIN gtfw_group_menu gm ON gm.`groupmenu_group_id` = r.group_id
INNER JOIN gtfw_group_module ggm ON ggm.`groupmodule_group_id` = r.group_id
LEFT JOIN gtfw_module md ON md.`module_menu_id` = gm.`groupmenu_menu_id` AND ggm.`groupmodule_module_id` = md.`module_id`
GROUP BY gm.`groupmenu_menu_id`    
";
$sql['get_menu_list'] = '
SELECT
	m.`menu_id` AS `id`,
	m.`menu_parent_id` AS `parent_id`,
	b.`menutext_menu_name` AS `name`,
	md.`module` AS `mod`,
	md.`module_sub_module` AS `sub`,
	md.`module_action_id` AS `act`,
	md.`module_type` AS `typ`,
	m.`menu_menu_order` AS `order`,
	GROUP_CONCAT(DISTINCT(gmd.`module_action_id`)) AS `action`,	
	GROUP_CONCAT(DISTINCT(c.`actiontext_action_label`)) AS `action_name`
FROM (
	SELECT
		%d AS app_id
) r
LEFT JOIN gtfw_menu m ON m.`menu_application_id` = r.app_id AND m.`menu_is_show` =  \'Yes\'
LEFT JOIN gtfw_module md ON md.`module_id` = m.`menu_default_module_id`
LEFT JOIN gtfw_module gmd ON gmd.`module_menu_id` = m.`menu_id`
LEFT JOIN gtfw_action ga ON ga.`action_id` = gmd.`module_action_id`
left join gtfw_menu_text b on b.`menutext_menu_id` = m.`menu_id` and b.`menutext_lang_code` = %d
left join gtfw_action_text c on c.`actiontext_action_id` = ga.`action_id` and c.`actiontext_lang_code` = %s
WHERE
	m.`menu_id` != 0
GROUP BY m.`menu_id`
ORDER BY m.`menu_parent_id`, m.`menu_menu_order`
';
$sql['get_action_list'] = "
SELECT
  a.`action_id` AS `id`,
  b.`actiontext_action_label` AS `name`
FROM gtfw_action a
LEFT JOIN gtfw_action_text b ON b.`actiontext_action_id` = a.`action_id` AND b.`actiontext_lang_code` = '%s'
";
$sql['insert_group_menu'] = '
INSERT INTO gtfw_group_menu (
  groupmenu_group_id,
  groupmenu_menu_id
) 
VALUES
  (
    %d,
    %d
  )
';
$sql['insert_group_module_by_menu'] = '
INSERT INTO gtfw_group_module (
  groupmodule_group_id,
  groupmodule_module_id
) 
SELECT 
  %d AS group_id,
  md.module_id 
FROM
  gtfw_module md 
WHERE md.module_menu_id = %d
--and--
';
$sql['delete_group_menu'] = '
DELETE 
FROM
  gtfw_group_menu 
WHERE groupmenu_group_id = %d
';
$sql['delete_group_module'] = '
DELETE 
FROM
  gtfw_group_module 
WHERE groupmodule_group_id = %d
';
$sql['chek_group_used'] = "
SELECT 
  `usergroup_user_id` 
FROM
  `gtfw_user_group` 
WHERE `usergroup_group_id` = %d
";
$sql['list_group'] = '
SELECT 
  a.group_id AS "id",
  a.group_name AS "name" ,
  b.`application_id` AS application_id
FROM
  gtfw_group a
LEFT JOIN gtfw_application b ON b.`application_id` = a.`group_application_id`
WHERE a.group_application_id = %d
';
