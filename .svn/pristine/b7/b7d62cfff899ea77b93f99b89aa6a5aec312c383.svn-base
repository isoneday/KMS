<?php

$sql['list_available_widget'] = '
SELECT
	w.widget_id AS `id`,
    w.widget_name AS `name`,
	w.widget_resizable AS resize,
	w.widget_row AS `row`,
	w.widget_col AS `col`,
	w.widget_sizex AS sizex,
	w.widget_sizey AS sizey,
	md.module_id AS `module_id`,
	md.module AS `mod`,
	md.module_sub_module AS `sub`,
	md.module_action AS `act`,
	md.module_type AS `typ`,
	md.module_desc AS `desc`
FROM
	gtfw_module md
LEFT JOIN gtfw_group_module gmd ON gmd.groupmodule_module_id = md.module_id
LEFT JOIN gtfw_user_group gug ON gug.usergroup_group_id = gmd.groupmodule_group_id
INNER JOIN gtfw_widget w ON md.module_id = w.widget_module_id
WHERE
	(gug.usergroup_user_id = %1$s OR md.module_access = \'all\')
	AND md.module_action = \'widget\'
	--filter_menus--
	AND md.module_id NOT IN (
		SELECT
			wg.widget_module_id
		FROM gtfw_user_widget uwg
		LEFT JOIN gtfw_widget wg ON wg.widget_id = uwg.userwidget_widget_id
		WHERE 
			uwg.userwidget_user_id = %1$s
			--filter_menu--
	)
GROUP BY md.module_id
';
$sql['get_user_widget'] = '
SELECT
	w.widget_id AS `id`,
    w.widget_name AS `name`,
	w.widget_resizable AS resize,
    wg.userwidget_menu_id AS `menu_id`,
	IFNULL(wg.userwidget_row, w.widget_row) AS `row`,
	IFNULL(wg.userwidget_col, w.widget_col) AS `col`,
	IFNULL(wg.userwidget_sizex, w.widget_sizex) AS sizex,
	IFNULL(wg.userwidget_sizey, w.widget_sizey) AS sizey,
	md.module_id AS `mod_id`,
	md.module AS `mod`,
	md.module_sub_module AS `sub`,
	md.module_action AS `act`,
	md.module_type AS `typ`
FROM
	gtfw_user_widget wg
LEFT JOIN gtfw_widget w ON w.widget_id = wg.userwidget_widget_id
LEFT JOIN gtfw_module md ON md.module_id = w.widget_module_id
LEFT JOIN gtfw_group_module gmd ON gmd.groupmodule_module_id = md.module_id
LEFT JOIN gtfw_user_group gug ON gug.usergroup_group_id = gmd.groupmodule_group_id
WHERE
	wg.userwidget_user_id = %1$s
	AND (gug.usergroup_user_id = %1$s OR md.module_access = \'all\')
    --menu_id--
GROUP BY w.widget_id
';

$sql['delete_user_widget'] = "
DELETE
FROM `gtfw_user_widget`
WHERE `userwidget_user_id` = %d
    AND `userwidget_menu_id` = %d
";

$sql['insert_user_widget'] = "
INSERT INTO `gtfw_user_widget` (
  `userwidget_user_id`,
  `userwidget_menu_id`,
  `userwidget_widget_id`,
  `userwidget_sizex`,
  `userwidget_sizey`,
  `userwidget_row`,
  `userwidget_col`
) 
VALUES
  (
    %d,
    %d,
    %d,
    %d,
    %d,
    %d,
    %d
  )
";