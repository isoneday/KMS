<?php

$sql['get_module_name'] = "
SELECT
	md.module
FROM
	`gtfw_menu` m
INNER JOIN gtfw_module md ON md.module_id = m.menu_default_module_id
WHERE
	m.menu_id = %d
";
$sql['show_create_table'] = "
SHOW CREATE TABLE %s
";
$sql['get_all_rows'] = "
SELECT * FROM %s
";
$sql['get_menus'] = "
SELECT * FROM gtfw_menu
WHERE
    1 = 1
    --filter--
";
$sql['get_menu_texts'] = "
SELECT * FROM gtfw_menu_text
WHERE
    1 = 1
    --filter--
";
$sql['get_modules'] = "
SELECT * FROM gtfw_module
WHERE
    1 = 1
    --filter-- 
";