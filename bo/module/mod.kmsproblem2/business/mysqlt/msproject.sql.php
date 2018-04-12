<?php

$sql["count_msproject"] = "
SELECT FOUND_ROWS() AS total
";
$sql["get_msproject"] = "
SELECT SQL_CALC_FOUND_ROWS 
    a.project_id AS `id`,
    a.project_name AS `name`,
    a.project_code AS `code`,
    a.project_hyperion AS `hyperion`,
    a.project_status AS `is_project`,
	b.company_name AS `company`
FROM ms_project a
LEFT JOIN ref_company b ON a.company_id = b.company_id
WHERE
    1 = 1
    --search--
ORDER BY a.project_status DESC, b.company_name ASC, a.project_code ASC, a.project_name  ASC
--limit--      
";
$sql["get_detail_msproject"] = "
SELECT 
    a.project_id AS `id`,
    a.project_name AS `name`,
    a.project_code AS `code`,
    a.project_hyperion AS `hyperion`,
    a.project_status AS `is_project`,
	a.company_id AS `company_id`,
	b.company_name AS `company`
FROM ms_project a
LEFT JOIN ref_company b ON a.company_id = b.company_id
WHERE project_id = %d
";
$sql["getCompanyId"] = "
SELECT 
    a.company_id AS `id`
FROM ref_company a
WHERE a.company_name = %s
";
$sql["insert_msproject"] = "
INSERT INTO ms_project
(
    project_name,
    project_code,
    project_hyperion,
    company_id,
    project_status
) VALUES (
    %s,
    %s,
    %s,
	%s,
	%s
)
";
$sql["update_msproject"] = "
UPDATE ms_project
SET 
    project_name = %s,
    project_code = %s,
    project_hyperion = %s,
    company_id = %s,
    project_status = %s
WHERE project_id = %d
";
$sql["delete_msproject"] = "
DELETE FROM ms_project
WHERE project_id = %d
";
$sql["replaceProject"] = "DELETE FROM ms_project";
$sql["list_msproject"] = "
SELECT
    project_id AS `ID`,
    project_name AS `NAME`,
	project_code AS 'CODE',
	project_hyperion AS 'HYPERION'
FROM
    ms_project
ORDER BY project_name
";

$sql["listCompany"] = "
SELECT
    company_id AS `id`,
    company_name AS `label`
FROM
    ref_company
ORDER BY company_name
";