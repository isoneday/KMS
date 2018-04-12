<?php

$sql["count_language"] = "
SELECT 
    COUNT(lang_code) AS total
FROM gtfw_lang
WHERE
    1 = 1
    --search--
";
$sql["get_language"] = "
SELECT 
    lang_code AS `code`,
    lang_name AS `name`,
    lang_icon_path AS `icon_path`,
    lang_desc AS `description`,
    insert_user_id AS `insert_user_id`,
    insert_timestamp AS `insert_timestamp`,
    update_user_id AS `update_user_id`,
    update_timestamp AS `update_timestamp`
FROM gtfw_lang
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_language"] = "
SELECT 
    lang_code AS `code`,
    lang_name AS `name`,
    lang_icon_path AS `icon_path`,
    lang_desc AS `description`,
    insert_user_id AS `insert_user_id`,
    insert_timestamp AS `insert_timestamp`,
    update_user_id AS `update_user_id`,
    update_timestamp AS `update_timestamp`
FROM gtfw_lang
WHERE lang_code = %s
";
$sql["insert_language"] = "
INSERT INTO gtfw_lang
(
    lang_code,
    lang_name,
    lang_icon_path,
    lang_desc,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    %s,
    %s,
    %s,
    NOW()
)
";
$sql["update_language"] = "
UPDATE gtfw_lang
SET 
    lang_code = %s,
    lang_name = %s,
    lang_icon_path = %s,
    lang_desc = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE lang_code = %s
";
$sql["delete_language"] = "
DELETE FROM gtfw_lang
WHERE lang_code = %s
";
$sql['list_lang_code'] = '
SELECT 
  lang_code AS "id",
  CONCAT(\'[\', lang_code, \']\', lang_name) AS "name" 
FROM
  gtfw_lang 
';