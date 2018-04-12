<?php

$sql["count_privacypolice"] = "
SELECT 
    COUNT(policy_id) AS total
FROM cms_privacy_policy
WHERE
    1 = 1
    --search--
";
$sql["get_privacypolice"] = "
SELECT 
    a.policy_id AS `id`,
    a.policy_name AS `name`,
    a.policy_info AS `info`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    IFNULL(CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM cms_privacy_policy a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_privacypolice"] = "
SELECT 
    a.policy_id AS `id`,
    a.policy_name AS `name`,
    a.policy_info AS `info`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%%d %%b %%Y %%H:%%i')) AS last_insert
FROM cms_privacy_policy a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
ORDER BY id DESC
LIMIT 1
";
$sql["insert_privacypolice"] = "
INSERT INTO cms_privacy_policy
(
    policy_name,
    policy_info,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    %s,
    NOW()
)
";
$sql["update_privacypolice"] = "
UPDATE cms_privacy_policy
SET 
    policy_name = %s,
    policy_info = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE policy_id = %d
";
$sql["delete_privacypolice"] = "
DELETE FROM cms_privacy_policy
WHERE policy_id = %d
";
$sql["list_privacypolice"] = "
SELECT
    policy_id AS `id`,
    policy_name AS `name`
FROM
    cms_privacy_policy
ORDER BY policy_name
";