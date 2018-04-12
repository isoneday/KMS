<?php

$sql['count_data'] = "
SELECT FOUND_ROWS() AS total
";
$sql['get_data'] = "
SELECT SQL_CALC_FOUND_ROWS
	m.menu_id AS dataId,
	m.menu_parent_id AS parentId,
	mt.menutext_menu_name AS menu_name,
	pmt.menutext_menu_name AS parent_name
FROM
(
	SELECT '%s' AS lang
) r
LEFT JOIN gtfw_menu AS m ON 1 = 1
LEFT JOIN gtfw_menu_text AS mt ON mt.menutext_menu_id = m.menu_id AND mt.menutext_lang_code = r.lang
LEFT JOIN gtfw_menu AS pm ON pm.menu_id = m.menu_parent_id
LEFT JOIN gtfw_menu_text AS pmt ON pmt.menutext_menu_id = m.menu_parent_id AND pmt.menutext_lang_code = r.lang
WHERE
	m.menu_id != 0
    --search--
  AND m.menu_application_id=%d
ORDER BY pm.menu_menu_order, pm.menu_id, m.menu_menu_order, m.menu_id
--limit--
";
$sql['get_detail'] = "
SELECT
	m.menu_id AS dataId,
	m.menu_parent_id AS parent,
	m.menu_desc AS `desc`,
	m.menu_is_show AS `show`,
	m.menu_menu_order AS `order`,
	m.menu_icon_path AS icon,
	m.menu_icon_small AS icon_small,
	m.menu_icon_large AS icon_large,
	m.menu_view_model AS view_model,
	m.menu_is_system_menu AS is_system_menu,
	m.menu_class_style AS class
FROM
	gtfw_menu AS m
WHERE
	m.menu_id = %d
";

$sql['get_menu_text'] = "
SELECT
	l.lang_code AS `code`,
	t.menutext_menu_name AS text
FROM
    (SELECT %d AS menu_id) r
LEFT JOIN gtfw_lang AS l ON 1 = 1
LEFT JOIN gtfw_menu_text AS t ON t.menutext_menu_id = r.menu_id AND l.lang_code = t.menutext_lang_code
";
$sql['get_menu_text_desc'] = "
SELECT
	l.lang_code AS `code`,
	t.menutext_menu_desc AS text
FROM
    (SELECT %d AS menu_id) r
LEFT JOIN gtfw_lang AS l ON 1 = 1
LEFT JOIN gtfw_menu_text AS t ON t.menutext_menu_id = r.menu_id AND l.lang_code = t.menutext_lang_code
";
$sql['list_parent'] = "
SELECT
	m.menu_id AS `id`,
	mt.menutext_menu_name AS `name`
FROM gtfw_menu m
LEFT JOIN gtfw_menu_text mt ON mt.menutext_menu_id = m.menu_id AND mt.menutext_lang_code = %s
WHERE
	menu_parent_id IN (
	SELECT
		menu_id
	FROM gtfw_menu
	WHERE
		menu_parent_id = 0
	)
";

$sql['add_menu'] = "
INSERT INTO gtfw_menu (
  menu_parent_id,
  menu_default_module_id,
  menu_desc,
  menu_is_show,
  menu_icon_large,
  menu_icon_path,
  menu_icon_small,
  menu_menu_order,
  menu_application_id,
  menu_view_model,
  menu_class_style,
  menu_is_system_menu,
  insert_user_id,
  insert_timestamp
) 
VALUES
  (
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %d,
    %d,
    %s,
    %d,
    NOW()
  )
";

$sql['update_menu'] = '
UPDATE 
  gtfw_menu 
SET
  menu_parent_id = %s,
  menu_desc = %s,
  menu_is_show = %d,
  menu_icon_large = %s, 
  menu_icon_path = %s,
  menu_icon_small = %s,
  menu_menu_order = %d,
  menu_view_model = %s,
  menu_class_style = %s,
  menu_is_system_menu = %s,
  update_user_id = %d,
  update_timestamp = NOW()
WHERE menu_id = %d
';

$sql['delete_menu_text'] = '
DELETE 
FROM
  gtfw_menu_text 
WHERE menutext_menu_id = %d
';

$sql['add_menu_text'] = "
INSERT INTO gtfw_menu_text (
  menutext_menu_id,
  menutext_lang_code,
  menutext_menu_name,
  menutext_menu_desc,
  insert_user_id,
  insert_timestamp
) 
VALUES
  (
    %d,
    %s,
    %s,
    %s,
    %d,
    NOW()
  )
";

$sql['list_menu'] = "
SELECT
	m.menu_id AS `id`,
    m.menu_parent_id AS `parent_id`,
	mt.menutext_menu_name AS `name`
FROM gtfw_menu m
LEFT JOIN gtfw_menu_text mt ON mt.menutext_menu_id = m.menu_id AND mt.menutext_lang_code = %s
WHERE
	mt.menutext_menu_name IS NOT NULL
        AND m.`menu_application_id` = %s
ORDER BY m.menu_parent_id, mt.menutext_menu_name
";

$sql['delete_menu_text'] = '
DELETE 
FROM
  gtfw_menu_text 
WHERE menutext_menu_id = %d 
';

$sql['delete_menu'] = '
DELETE 
FROM
  gtfw_menu 
WHERE menu_id = %d 
';
?>