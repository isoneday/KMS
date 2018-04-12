<?php
$sql['list_menu'] = '
SELECT
	m.menu_id AS "id",
	m.menu_parent_id AS "parent_id",
	t.menutext_menu_name AS "title",
	md.module AS "mod",
	md.module_sub_module AS "sub",
	md.module_action AS "act",
	md.module_type AS "typ",
	m.menu_menu_order AS "position",
	m.menu_icon_path AS "icon",
	m.menu_icon_small AS "icon_small",
    m.menu_icon_large AS "icon_large"
FROM (
	SELECT
		%s AS username,
		%d AS appId,
        %s AS lang
) r
INNER JOIN gtfw_user gu ON gu.user_user_name = r.username
LEFT JOIN gtfw_user_group gug ON gu.user_id = gug.usergroup_user_id 
LEFT JOIN gtfw_group g ON gug.usergroup_group_id = g.group_id
LEFT JOIN gtfw_group_menu gg ON g.group_id = gg.groupmenu_group_id
LEFT JOIN gtfw_menu m ON gg.groupmenu_menu_id = m.menu_id AND m.menu_application_id = r.appId
LEFT JOIN gtfw_menu_text t ON t.menutext_menu_id = m.menu_id AND t.menutext_lang_code = r.lang
LEFT JOIN gtfw_module md ON md.module_id = m.menu_default_module_id
WHERE
    m.menu_is_show = \'Yes\'
    --filter--
GROUP BY m.menu_id
ORDER BY
	m.menu_parent_id, m.menu_menu_order,
	m.menu_id
';
$sql['list_menu_module'] = '
SELECT
	m.menu_id AS "id",
	m.menu_parent_id AS "parent_id",
	t.menutext_menu_name AS "title",
	md.module AS "mod",
	md.module_sub_module AS "sub",
	md.module_action AS "act",
	md.module_type AS "typ",
	m.menu_menu_order AS "position",
	m.menu_icon_path AS "icon",
	m.menu_icon_small AS "icon_small",
    m.menu_icon_large AS "icon_large"
FROM (
	SELECT
		%s AS username,
		%d AS appId,
        %s AS lang,
        %d AS mId
) r
INNER JOIN gtfw_user gu ON gu.user_user_name = r.username
LEFT JOIN gtfw_user_group gug ON gu.user_id = gug.usergroup_user_id 
LEFT JOIN gtfw_group g ON gug.usergroup_group_id = g.group_id
LEFT JOIN gtfw_group_menu gg ON g.group_id = gg.groupmenu_group_id
INNER JOIN gtfw_menu m ON gg.groupmenu_menu_id = m.menu_id AND m.menu_parent_id = r.mId AND m.menu_application_id = r.appId
LEFT JOIN gtfw_menu_text t ON t.menutext_menu_id = m.menu_id AND t.menutext_lang_code = r.lang
LEFT JOIN gtfw_module md ON md.module_id = m.menu_default_module_id
WHERE
    m.menu_is_show = \'Yes\'
GROUP BY m.menu_id
ORDER BY
	m.menu_parent_id, m.menu_menu_order,
	m.menu_id
';
$sql['list_landing_page_menu'] = '
SELECT
	m.menu_id AS "id",
	m.menu_parent_id AS "parent_id",
	t.menutext_menu_name AS "title",
	md.module AS "mod",
	md.module_sub_module AS "sub",
	md.module_action AS "act",
	md.module_type AS "typ",
	m.menu_menu_order AS "position",
	m.menu_icon_path AS "icon",
	m.menu_icon_small AS "icon_small",
    m.menu_icon_large AS "icon_large"
FROM (
	SELECT
		%s AS username,
		%d AS appId,
        %s AS lang
) r
INNER JOIN gtfw_user gu ON gu.user_user_name = r.username
LEFT JOIN gtfw_user_group gug ON gu.user_id = gug.usergroup_user_id 
LEFT JOIN gtfw_group g ON gug.usergroup_group_id = g.group_id
LEFT JOIN gtfw_group_menu gg ON g.group_id = gg.groupmenu_group_id
LEFT JOIN gtfw_menu m ON gg.groupmenu_menu_id = m.menu_id AND m.menu_application_id = r.appId
LEFT JOIN gtfw_menu_text t ON t.menutext_menu_id = m.menu_id AND t.menutext_lang_code = r.lang
LEFT JOIN gtfw_module md ON md.module_id = m.menu_default_module_id
WHERE
    m.menu_parent_id = 0
    AND m.menu_is_show = \'Yes\'
    AND m.menu_is_system_menu = 0
GROUP BY m.menu_id
ORDER BY
	m.menu_parent_id, m.menu_menu_order,
	m.menu_id
';
$sql['list_module_menu'] = '
SELECT
	m.menu_id AS "id",
	m.menu_parent_id AS "parent_id",
	t.menutext_menu_name AS "title",
	md.module AS "mod",
	md.module_sub_module AS "sub",
	md.module_action AS "act",
	md.module_type AS "typ",
	m.menu_menu_order AS "position",
	m.menu_icon_path AS "icon",
	m.menu_icon_small AS "icon_small",
    m.menu_icon_large AS "icon_large"
FROM (
	SELECT
		%s AS username,
		%d AS appId,
        %s AS lang
) r
INNER JOIN gtfw_user gu ON gu.user_user_name = r.username
LEFT JOIN gtfw_user_group gug ON gu.user_id = gug.usergroup_user_id 
LEFT JOIN gtfw_group g ON gug.usergroup_group_id = g.group_id
LEFT JOIN gtfw_group_menu gg ON g.group_id = gg.groupmenu_group_id
LEFT JOIN gtfw_menu m ON gg.groupmenu_menu_id = m.menu_id AND m.menu_application_id = r.appId
LEFT JOIN gtfw_menu_text t ON t.menutext_menu_id = m.menu_id AND t.menutext_lang_code = r.lang
LEFT JOIN gtfw_module md ON md.module_id = m.menu_default_module_id
WHERE
    m.menu_parent_id = 0
    AND m.menu_is_show = \'Yes\'
    AND m.menu_is_system_menu = 0
GROUP BY m.menu_id
ORDER BY
	m.menu_parent_id, m.menu_menu_order,
	m.menu_id
';
$sql['list_top_menu'] = '
SELECT
	m.menu_id AS "id",
	m.menu_parent_id AS "parent_id",
	t.menutext_menu_name AS "title",
	md.module AS "mod",
	md.module_sub_module AS "sub",
	md.module_action AS "act",
	md.module_type AS "typ",
	m.menu_menu_order AS "position",
	m.menu_icon_path AS "icon",
	m.menu_icon_small AS "icon_small",
	m.menu_class_style AS "menu_style",
        m.menu_icon_large AS "icon_large"
FROM (
	SELECT
		%s AS username,
		%d AS appId,
        %s AS lang
) r
INNER JOIN gtfw_user gu ON gu.user_user_name = r.username
LEFT JOIN gtfw_user_group gug ON gu.user_id = gug.usergroup_user_id 
LEFT JOIN gtfw_group g ON gug.usergroup_group_id = g.group_id
LEFT JOIN gtfw_group_menu gg ON g.group_id = gg.groupmenu_group_id
LEFT JOIN gtfw_menu m ON gg.groupmenu_menu_id = m.menu_id AND m.menu_application_id = r.appId
LEFT JOIN gtfw_menu_text t ON t.menutext_menu_id = m.menu_id AND t.menutext_lang_code = r.lang
LEFT JOIN gtfw_module md ON md.module_id = m.menu_default_module_id
WHERE
    m.menu_parent_id = 0
    AND m.menu_is_show = \'Yes\'
    AND m.menu_is_system_menu = 1
GROUP BY m.menu_id
ORDER BY
	m.menu_parent_id, m.menu_menu_order,
	m.menu_id
';
?>    
