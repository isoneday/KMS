<?php

$sql["count_group"] = "
SELECT FOUND_ROWS() AS total
";
$sql["get_group"] = "
SELECT SQL_CALC_FOUND_ROWS
    group_id AS `id`,
    group_name AS `name`,
    group_application_id AS `application_id`,
    group_desc AS `description`,
    insert_user_id AS `insert_user_id`,
    insert_timestamp AS `insert_timestamp`,
    update_user_id AS `update_user_id`,
    update_timestamp AS `update_timestamp`
FROM gtfw_group
WHERE
    1 = 1
    AND group_application_id = %d
    --search--
--limit--    
";
$sql["get_detail_group"] = "
SELECT 
    group_id AS `id`,
    group_name AS `name`,
    group_application_id AS `application_id`,
    group_desc AS `description`,
    insert_user_id AS `insert_user_id`,
    insert_timestamp AS `insert_timestamp`,
    update_user_id AS `update_user_id`,
    update_timestamp AS `update_timestamp`
FROM gtfw_group
WHERE group_id = %d
";
$sql["insert_group"] = "
INSERT INTO gtfw_group
(
    group_name,
    group_application_id,
    group_desc,
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
$sql["update_group"] = "
UPDATE gtfw_group
SET 
    group_name = %s,
    group_application_id = %s,
    group_desc = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE group_id = %d
";
$sql["delete_group"] = "
DELETE FROM gtfw_group
WHERE group_id = %d
";

$sql['get_menu_list'] = '
SELECT
	m.menu_id AS `id`,
	m.menu_parent_id AS `parent_id`,
	t.menutext_menu_name AS `name`,
	md.module AS `mod`,
	md.module_sub_module AS `sub`,
	md.module_action AS `act`,
	md.module_type AS `typ`,
	m.menu_menu_order AS `order`,
	GROUP_CONCAT(DISTINCT(gmd.module_action_id)) AS `action`,	
	GROUP_CONCAT(DISTINCT(gat.actiontext_action_label)) AS `action_name`
FROM (
	SELECT
		%d AS app_id,
		%s AS lang_code
) r
LEFT JOIN gtfw_menu m ON m.menu_application_id = r.app_id
LEFT JOIN gtfw_menu_text t ON t.menutext_menu_id = m.menu_id AND t.menutext_lang_code = r.lang_code
LEFT JOIN gtfw_module md ON md.module_id = m.menu_default_module_id
LEFT JOIN gtfw_module gmd ON gmd.module_menu_id = m.menu_id
LEFT JOIN gtfw_action_text gat ON gat.actiontext_action_id = gmd.module_action_id AND gat.actiontext_lang_code = r.lang_code
WHERE
	m.menu_id != 0
    AND m.menu_is_show = \'Yes\'
GROUP BY m.menu_id
ORDER BY m.menu_parent_id, m.menu_menu_order
';

$sql['get_access_group'] = '
SELECT
	gm.groupmenu_menu_id AS menu_id,
	CAST(GROUP_CONCAT(DISTINCT(md.module_action_id)) AS CHAR) AS actions
FROM (
	SELECT
		%d AS group_id
) r
INNER JOIN gtfw_group_menu gm ON gm.groupmenu_group_id = r.group_id
INNER JOIN gtfw_group_module ggm ON ggm.groupmodule_group_id = r.group_id
LEFT JOIN gtfw_module md ON md.module_menu_id = gm.groupmenu_menu_id AND ggm.groupmodule_module_id = md.module_id
GROUP BY gm.groupmenu_menu_id
';

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
$sql['list_group'] = '
SELECT 
  group_id AS "id",
  group_name AS "name" 
FROM
  gtfw_group 
WHERE group_application_id = %d
';
$sql['list_group_to_employee'] = '
SELECT 
  group_id AS "id",
  group_name AS "name" 
FROM
  gtfw_group 
WHERE group_application_id = %d
';
$sql['get_action_list'] = "
SELECT
  action_id AS `id`,
  actiontext_action_label AS `name`
FROM gtfw_action
LEFT JOIN gtfw_action_text ON actiontext_action_id = action_id AND actiontext_lang_code = %s
";
$sql['chek_group_used'] = "
SELECT 
  `usergroup_user_id` 
FROM
  `gtfw_user_group` 
WHERE `usergroup_group_id` = %d
";