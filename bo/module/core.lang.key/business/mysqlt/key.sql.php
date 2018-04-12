<?php

$sql["count_key"] = "
SELECT FOUND_ROWS() AS total
";
$sql["get_key"] = "
SELECT SQL_CALC_FOUND_ROWS
    key_id AS `id`,
    key_code AS `code`,
    insert_user_id AS `insert_user_id`,
    insert_timestamp AS `insert_timestamp`,
    update_user_id AS `update_user_id`,
    update_timestamp AS `update_timestamp`
FROM gtfw_key
WHERE
    1 = 1
    --search--
ORDER BY key_code
--limit--    
";
$sql["get_detail_key"] = "
SELECT 
    key_id AS `id`,
    key_code AS `code`,
    insert_user_id AS `insert_user_id`,
    insert_timestamp AS `insert_timestamp`,
    update_user_id AS `update_user_id`,
    update_timestamp AS `update_timestamp`
FROM gtfw_key
WHERE key_id = %d
";
$sql["insert_key"] = "
INSERT INTO gtfw_key
(
    key_code,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    NOW()
)
";
$sql["update_key"] = "
UPDATE gtfw_key
SET 
    key_code = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE key_id = %d
";
$sql["delete_key"] = "
DELETE FROM gtfw_key
WHERE key_id = %d
";

$sql['get_lang'] = "
SELECT 
  lang_code AS kode,
  lang_name AS nama
FROM
  gtfw_lang l 
ORDER BY lang_code
";

$sql['get_key_text'] = "
SELECT
	k.key_id AS `id`,
	l.lang_code AS `kode`,
	l.lang_name AS `name`,
	t.key_text_key_text AS `translate`
FROM gtfw_key k
LEFT JOIN gtfw_lang l ON 1 = 1
LEFT JOIN gtfw_key_text t ON k.key_id = t.key_text_key_id AND t.key_text_lang_code = l.lang_code
";

$sql['get_lang_by_key'] = "
SELECT 
  lang_code AS kode,
  lang_name AS nama,
  k.`key_text_key_text` AS translate 
FROM 
	(SELECT %d AS id) r
LEFT JOIN gtfw_lang l ON 1 = 1
LEFT JOIN gtfw_key_text k 
    ON l.`lang_code` = k.`key_text_lang_code` AND k.`key_text_key_id` = r.id
";

$sql['insert_key_text'] = "
INSERT INTO gtfw_key_text (
  key_text_key_id,
  key_text_lang_code,
  key_text_key_text,
  insert_user_id,
  insert_timestamp
) VALUE ('%s', '%s', '%s', '%s', NOW())
";

$sql['update_key_text'] = "
UPDATE 
  gtfw_key_text 
SET
  key_text_key_text = '%s',
  update_user_id = '%s',
  update_timestamp = NOW() 
WHERE key_text_key_id = '%s' 
  AND key_text_lang_code = '%s' 
";

$sql['delete_key_text'] = "
DELETE 
FROM
  gtfw_key_text 
WHERE key_text_key_id = '%s' 
";

$sql['get_key_by_prefix'] = "
SELECT
	k.key_code AS `code`,
	t.key_text_key_text AS `text`
FROM 
	gtfw_key k
LEFT JOIN gtfw_key_text t ON t.key_text_key_id = k.key_id
LEFT JOIN gtfw_lang l ON l.lang_code = t.key_text_lang_code
WHERE
	l.lang_code = '%s' 
	AND k.key_code LIKE '%s'
";

$sql['check_key'] = "
SELECT
	k.key_code AS `code`
FROM 
	gtfw_key k
WHERE
	k.key_code = '%s' 
	--filter--
";