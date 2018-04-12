<?php

$sql['list_menu'] = "
SELECT
	m.menu_id AS id,
	mt.menutext_menu_name AS `name`
FROM
	gtfw_menu AS m
INNER JOIN gtfw_menu_text AS mt ON mt.menutext_menu_id = m.menu_id
WHERE
	mt.menutext_lang_code = %s
";

$sql['list_table'] = "
SHOW TABLES
";

$sql['list_actions'] = "
SELECT
	a.action_id AS id,
	a.action_code AS code,
	t.actiontext_action_label AS name 
FROM
	gtfw_action a
INNER JOIN gtfw_action_text t ON t.actiontext_action_id = a.action_id AND t.actiontext_lang_code = %s
";

$sql['get_table_column'] = '
SHOW COLUMNS FROM %s
';

$sql['add_menu'] = "
INSERT INTO gtfw_menu (
  menu_is_show,
  menu_application_id,
  insert_user_id,
  insert_timestamp
) 
VALUES
  (
	'Yes',
	%d,
	%d,
	NOW()
  )
";

$sql['add_menu_text'] = "
INSERT INTO gtfw_menu_text (
  menutext_menu_id,
  menutext_lang_code,
  menutext_menu_name,
  insert_user_id,
  insert_timestamp
) 
VALUES
  (
    %d,
    %s,
    %s,
    %d,
    NOW()
  )
";

$sql['add_module'] = "
INSERT INTO gtfw_module (
  module,
  module_sub_module,
  module_action,
  module_type,
  module_desc,
  module_access,
  module_menu_id,
  module_application_id,
  module_action_id,
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
    %d,
    %d,
    %d,
    %d,
    NOW()
  )
";

$sql['set_default_module'] = "
UPDATE 
  gtfw_menu 
SET
  menu_default_module_id = %d
WHERE menu_id = %d
";