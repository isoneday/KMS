<?php
$sql['nav'] = '
SELECT
	DISTINCT gm."menu_id",
	gm."menu_icon_small" AS "icon",
	gmt."menutext_menu_name" AS "name",
	gmod."module" AS "mod",
	gmod."module_sub_module" AS "sub",
	gmod."module_action" AS "act",
	gmod."module_type" AS "typ",
	\'&mid=\'||ggm."groupmenu_menu_id"||\'&dmmid=\'||gm."menu_id" AS "url",
	sgm."menu_icon_small" AS "sub_icon",
	sgmt."menutext_menu_name" AS "sub_name",
	sgmod."module" AS "sub_mod",
	sgmod."module_sub_module" AS "sub_sub",
	sgmod."module_action" AS "sub_act",
	sgmod."module_type" AS "sub_typ",
	gm."menu_menu_order" AS "parent_menu_order", 
	sgm."menu_menu_order" AS "child_menu_order"
FROM (
	SELECT
		%s AS username,
		%d AS applicationid,
		\'Yes\' AS isshow,
		%s AS lang
	FROM DUAL
) r
LEFT JOIN "gtfw_user" gu ON gu."user_user_name" = r.username
LEFT JOIN "gtfw_user_group" gug ON gug."usergroup_user_id" = gu."user_id"
LEFT JOIN "gtfw_group" gg ON gg."group_id" = gug."usergroup_group_id" AND gg."group_application_id" = r.applicationid
LEFT JOIN "gtfw_group_menu" ggm ON ggm."groupmenu_group_id" = gg."group_id"
LEFT JOIN "gtfw_menu" gm ON gm."menu_id" = ggm."groupmenu_menu_id" AND gm."menu_is_show" = r.isshow
LEFT JOIN "gtfw_menu_text" gmt ON gmt."menutext_menu_id" = gm."menu_id" AND gmt."menutext_lang_code" = r.lang
LEFT JOIN "gtfw_module" gmod ON gmod."module_id" = gm."menu_default_module_id"
LEFT JOIN "gtfw_menu" sgm ON sgm."menu_parent_id" = gm."menu_id" AND sgm."menu_is_show" = r.isshow
LEFT JOIN "gtfw_menu_text" sgmt ON sgmt."menutext_menu_id" = sgm."menu_id" AND sgmt."menutext_lang_code" = r.lang
LEFT JOIN "gtfw_module" sgmod ON sgmod."module_id" = sgm."menu_default_module_id"
WHERE
	gm."menu_id" IS NOT NULL
	AND gm."menu_parent_id" IS NULL
ORDER BY gm."menu_menu_order", sgm."menu_menu_order"
';
?>    
