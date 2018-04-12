<?php

$sql["count_employeemini"] = "
SELECT FOUND_ROWS() AS total
";
$sql["get_employeemini"] = "
SELECT SQL_CALC_FOUND_ROWS
    a.emp_id AS `id`,
    a.emp_number AS `parent_number`,
    a.emp_access_code AS `presence_number`,
    a.emp_name AS `full_name`,
    a.emp_first_name AS `first_name`,
    a.emp_middle_name AS `middle_name`,
    a.emp_last_name AS `last_name`,
    a.emp_nick_name AS `nick_name`,
    a.emp_salutation_id AS `salutation_id`,
    a.emp_title_prefix AS `title_prefix`,
    a.emp_title_sufix AS `title_sufix`,
    a.emp_birth_place AS `birth_place`,
    a.emp_birth_date AS `birth_date`,
    a.emp_gender AS `gender`,
    a.emp_religion_id AS `religion_id`,
    a.emp_belief AS `belief`,
    a.emp_nationality_status AS nationality,
    a.emp_country_id AS `country_id`,
    a.emp_ethnic AS `ethnic`,
    a.emp_bloodtype_id AS `bloodtype_id`,
    c.`bloodtype_name` AS blood_name,
    a.emp_weight AS `weight`,
    a.emp_height AS `height`,
    a.emp_skin_color AS `skin_color`,
    a.emp_hair_color AS `hair_color`,
    a.emp_face_shape AS `face_shape`,
    a.emp_typical AS `typical`,
    a.emp_disability AS `disability`,
    a.emp_disease AS `disease`,
    a.emp_alergy AS `alergy`,
    a.emp_hobby AS `hobby`,
    a.emp_workpertype_id AS `period_type_id`,
    d.`workpertype_name` AS period_name,
    a.emp_train_date AS `train_date`,
    a.emp_join_date AS `join_date`,
    a.emp_quit_date AS `quit_date`,
    a.emp_is_vendor AS `is_vendor`,
    a.emp_is_customer AS `is_customer`,
    a.emp_status AS `status`,
    a.emp_desc AS `desc`,
    a.emp_is_locked AS `is_locked`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    a.unit_id AS `unit_id`,
    IFNULL(f.`emptype_name`,'- ') AS emp_type,
    IFNULL(h.`empstat_name`,'- ') AS emp_status,
    IFNULL(j.`strucpostype_name`,'- ') AS emp_position,
    IFNULL(l.`unit_name`,'- ') AS emp_unit,
    p.empuser_user_id AS user_id,
    zc.`photo_id` AS photo_id,
    zc.`photo_file` AS photo,
    zc.`photo_origin` AS photo_origin,
    zc.`photo_path` AS photo_path,
    zc.`photo_type` AS photo_type,
    zc.`photo_size` AS photo_size,
    IF((a.update_timestamp = NULL OR a.update_timestamp = '1900-01-01 00:00:00' OR a.update_timestamp = '0000-00-00 00:00:00'), IF ( (a.insert_timestamp = NULL OR a.insert_timestamp = '1900-01-01 00:00:00' OR a.insert_timestamp = '0000-00-0 00:00:00'), b.`user_real_name`, CONCAT( b.`user_real_name`, ', ', DATE_FORMAT( a.insert_timestamp, '%d %b %Y %H:%i' ))),CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i'))) AS last_modified
FROM emp_employee a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
LEFT JOIN ref_blood_type c ON c.`bloodtype_id` = a.`emp_bloodtype_id`
LEFT JOIN emp_ref_work_period_type d ON d.`workpertype_id` = a.`emp_workpertype_id`
LEFT JOIN emp_employee_contract e ON e.`empcontract_emp_id` = a.`emp_id`
LEFT JOIN emp_ref_employee_type f ON f.`emptype_id` = e.`empcontract_emptype_id`
LEFT JOIN emp_employee_status g ON g.`empstatus_emp_id` = a.`emp_id`
LEFT JOIN emp_ref_employee_status h ON h.`empstat_id` = g.`empstatus_empstat_id`
LEFT JOIN emp_structural_position i ON i.`strucpos_emp_id` = a.`emp_id`
LEFT JOIN ref_structural_position_type j ON j.`strucpostype_id` = i.`strucpos_strucpostype_id`
LEFT JOIN emp_employee_unit k ON k.`empunit_emp_id` = a.`emp_id`
LEFT JOIN gtfw_unit l ON l.`unit_id` = k.`empunit_unit_id`
LEFT JOIN ref_salutation m ON m.`salutation_id` = a.`emp_salutation_id`
LEFT JOIN ref_religion n ON n.`religion_id` = a.`emp_religion_id`
LEFT JOIN ref_country o ON o.`country_id` = a.`emp_country_id`
LEFT JOIN emp_employee_user p ON p.empuser_emp_id = a.emp_id
LEFT JOIN emp_address z ON z.`addr_emp_id` = a.`emp_id` AND z.`addr_addrtype_id` = 5
LEFT JOIN ref_state za ON za.`state_id` = z.`addr_state_id`
LEFT JOIN ref_country zb ON zb.`country_id` = z.`addr_country_id`
LEFT JOIN emp_photo zc ON zc.`photo_emp_id` = a.`emp_id` AND zc.`photo_phototype_id` = 1
WHERE
    1 = 1
    --search--
GROUP BY a.`emp_id`
ORDER BY a.`emp_name`
--limit--    
";
$sql["get_detail_employeemini"] = "
SELECT 
    a.emp_id AS `id`,
    a.emp_number AS `parent_number`,
    a.emp_access_code AS `presence_number`,
    a.emp_name AS `full_name`,
    a.emp_first_name AS `first_name`,
    a.emp_middle_name AS `middle_name`,
    a.emp_last_name AS `last_name`,
    a.emp_nick_name AS `nick_name`,
    a.emp_salutation_id AS `salutation_id`,
    m.`salutation_name` AS salutation_name,
    a.emp_title_prefix AS `title_prefix`,
    a.emp_title_sufix AS `title_sufix`,
    a.emp_birth_place AS `place_of_birth`,
    a.emp_birth_date AS `date_of_birth`,
    a.emp_gender AS `gender`,
    a.emp_religion_id AS `religion_id`,
    n.`religion_name` AS religion_name,
    a.emp_belief AS `belief`,
    a.emp_nationality_status AS nationality,
    a.emp_country_id AS `citizenship_id`,
    o.`country_nat_singular` AS nationality_name,
    a.emp_ethnic AS `ethnic`,
    a.emp_bloodtype_id AS `blood_type_id`,
    c.`bloodtype_name` AS blood_name,
    a.emp_weight AS `weight`,
    a.emp_height AS `height`,
    a.emp_skin_color AS `skin_color`,
    a.emp_hair_color AS `hair_color`,
    a.emp_face_shape AS `face_shape`,
    a.emp_typical AS `typical`,
    a.emp_disability AS `disability`,
    a.emp_disease AS `disease`,
    a.emp_alergy AS `alergy`,
    a.emp_hobby AS `hobby`,
    a.emp_workpertype_id AS `period_type_id`,
    d.`workpertype_name` AS period_name,
    a.emp_train_date AS `train_date`,
    a.emp_join_date AS `join_date`,
    a.emp_quit_date AS `quit_date`,
    a.emp_is_vendor AS `set_as_vendor`,
    a.emp_is_customer AS `set_as_customer`,
    a.emp_status AS `status`,
    a.emp_desc AS `desc`,
    a.emp_is_locked AS `is_locked`,
    a.insert_user_id AS `insert_user_id`,
    a.insert_timestamp AS `insert_timestamp`,
    a.update_user_id AS `update_user_id`,
    a.update_timestamp AS `update_timestamp`,
    a.unit_id AS `unit_id`,
    IFNULL(f.`emptype_name`,'- ') AS emp_type,
    IFNULL(h.`empstat_name`,'- ') AS emp_status,
    IFNULL(j.`strucpostype_name`,'- ') AS emp_position,
    IFNULL(l.`unit_name`,'- ') AS emp_unit,
    p.`empstatus_empstat_id` AS emp_status_id,
    p.`empstatus_start` AS status_valid_from,
    p.`empstatus_end` AS status_valid_until,
    q.`empstat_name` AS emp_status_name,
    r.`empunit_unit_id` AS emp_unit_id,
    r.`empunit_start` AS unit_valid_from,
    r.`empunit_end` AS unit_valid_until,
    s.`unit_name` AS emp_unit_name,
    t.`strucpos_strucpostype_id` AS emp_position_id,
    t.`strucpos_start` AS struct_valid_from,
    t.`strucpos_end` AS struct_valid_until,
    u.`strucpostype_name` AS emp_position_name,
    CONCAT(v.`empcontract_emptype_id`,'|',w.emptype_is_permanent) AS `emp_type_id`,
    v.`empcontract_period` AS period,
    v.`empcontract_period_unit` AS period_unit,
    v.`empcontract_start` AS valid_from,
    v.`empcontract_end` AS valid_until,
    v.`empcontract_first_reminder` AS first_reminder,
    v.`empcontract_second_reminder` AS second_reminder,
    v.`empcontract_third_reminder` AS third_reminder,
    v.`empcontract_final_reminder` AS final_reminder,
    w.`emptype_name` AS emp_type_name,
    zc.`photo_id` AS photo_id,
    zc.`photo_file` AS photo,
    zc.`photo_origin` AS photo_origin,
    zc.`photo_path` AS photo_path,
    zc.`photo_type` AS photo_type,
    zc.`photo_size` AS photo_size,
    zd.`email_email` AS `email`,
    ze.`officer_id` AS crm_officer_id,
    zf.`officer_id` AS hr_officer_id,
    zg.`officer_id` AS fin_officer_id,
    zh.`officer_id` AS fxa_officer_id,
    zi.`officer_id` AS inv_officer_id,
    ab.`officer_id` AS ga_officer_id,
    ac.`officer_id` AS prod_officer_id,
    ad.`officer_id` AS proj_officer_id,
    ae.`officer_id` AS pcs_officer_id,
    af.`officer_id` AS qc_officer_id,
    ag.`officer_id` AS sales_officer_id,
    ah.`officer_id` AS cms_officer_id,
    ai.`officer_id` AS taf_officer_id,
    CONCAT(z.`addr_street`,', ',IFNULL(za.`state_name`,''),', ',IFNULL(zb.`country_name`,'')) AS address,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.update_timestamp,'%d %b %Y %H:%i')) AS last_update,
    CONCAT(b.`user_real_name`,', ',DATE_FORMAT(a.insert_timestamp,'%d %b %Y %H:%i')) AS last_insert
FROM emp_employee a
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
LEFT JOIN ref_blood_type c ON c.`bloodtype_id` = a.`emp_bloodtype_id`
LEFT JOIN emp_ref_work_period_type d ON d.`workpertype_id` = a.`emp_workpertype_id`
LEFT JOIN emp_employee_contract e ON e.`empcontract_emp_id` = a.`emp_id`
LEFT JOIN emp_ref_employee_type f ON f.`emptype_id` = e.`empcontract_emptype_id`
LEFT JOIN emp_employee_status g ON g.`empstatus_emp_id` = a.`emp_id`
LEFT JOIN emp_ref_employee_status h ON h.`empstat_id` = g.`empstatus_empstat_id`
LEFT JOIN emp_structural_position i ON i.`strucpos_emp_id` = a.`emp_id`
LEFT JOIN ref_structural_position_type j ON j.`strucpostype_id` = i.`strucpos_strucpostype_id`
LEFT JOIN emp_employee_unit k ON k.`empunit_emp_id` = a.`emp_id`
LEFT JOIN gtfw_unit l ON l.`unit_id` = k.`empunit_unit_id`
LEFT JOIN ref_salutation m ON m.`salutation_id` = a.`emp_salutation_id`
LEFT JOIN ref_religion n ON n.`religion_id` = a.`emp_religion_id`
LEFT JOIN ref_country o ON o.`country_id` = a.`emp_country_id`
LEFT JOIN emp_employee_status p ON p.`empstatus_emp_id` = a.`emp_id` AND CURDATE() BETWEEN p.`empstatus_start` AND p.`empstatus_end`
LEFT JOIN emp_ref_employee_status q ON q.`empstat_id` = p.`empstatus_empstat_id`
LEFT JOIN emp_employee_unit r ON r.`empunit_emp_id` = a.`emp_id` AND CURDATE() BETWEEN r.`empunit_start` AND r.`empunit_end`
LEFT JOIN gtfw_unit s ON s.`unit_id` = r.`empunit_unit_id` 
LEFT JOIN emp_structural_position t ON t.`strucpos_emp_id` = a.`emp_id` AND CURDATE() BETWEEN t.`strucpos_start` AND t.`strucpos_end`
LEFT JOIN ref_structural_position_type u ON u.`strucpostype_id` = t.`strucpos_strucpostype_id`
LEFT JOIN emp_employee_contract v ON v.`empcontract_emp_id` = a.`emp_id` AND CURDATE() BETWEEN v.`empcontract_start` AND v.`empcontract_end`
LEFT JOIN emp_ref_employee_type w ON w.`emptype_id` = v.`empcontract_emptype_id`
LEFT JOIN emp_address z ON z.`addr_emp_id` = a.`emp_id` AND z.`addr_addrtype_id` = 5
LEFT JOIN ref_state za ON za.`state_id` = z.`addr_state_id`
LEFT JOIN ref_country zb ON zb.`country_id` = z.`addr_country_id`
LEFT JOIN emp_photo zc ON zc.`photo_emp_id` = a.`emp_id` AND zc.`photo_phototype_id` = 1
LEFT JOIN emp_email zd ON zd.`email_emp_id` = a.`emp_id` AND zd.`email_emailtype_id` = 5
LEFT JOIN crm_officer ze ON ze.`officer_emp_id` = a.`emp_id`
LEFT JOIN emp_officer zf ON zf.`officer_emp_id` = a.`emp_id`
LEFT JOIN fin_officer zg ON zg.`officer_emp_id` = a.`emp_id`
LEFT JOIN fxa_officer zh ON zh.`officer_emp_id` = a.`emp_id`
LEFT JOIN inv_officer zi ON zi.`officer_emp_id` = a.`emp_id`
LEFT JOIN ga_officer ab ON ab.`officer_emp_id` = a.`emp_id`
LEFT JOIN prod_officer ac ON ac.`officer_emp_id` = a.`emp_id`
LEFT JOIN proj_officer ad ON ad.`officer_emp_id` = a.`emp_id`
LEFT JOIN pcs_officer ae ON ae.`officer_emp_id` = a.`emp_id`
LEFT JOIN qc_officer af ON af.`officer_emp_id` = a.`emp_id`
LEFT JOIN sales_officer ag ON ag.`officer_emp_id` = a.`emp_id`
LEFT JOIN cms_officer ah ON ah.`officer_emp_id` = a.`emp_id`
LEFT JOIN taf_officer ai ON ai.`officer_emp_id` = a.`emp_id`
WHERE 
    1 = 1
    --search--
GROUP BY a.`emp_id`
ORDER BY a.`emp_name`
--limit--
";
$sql["insert_employeemini"] = "
INSERT INTO emp_employee
(
    emp_number,
    emp_system_code,
    emp_access_code,
    emp_name,
    emp_first_name,
    emp_middle_name,
    emp_last_name,
    emp_nick_name,
    emp_official_name,
    emp_salutation_id,
    emp_title_prefix,
    emp_title_sufix,
    emp_birth_place,
    emp_birth_date,
    emp_gender,
    emp_religion_id,
    emp_belief,
    emp_nationality_status,
    emp_country_id,
    emp_ethnic,
    emp_dialect,
    emp_bloodtype_id,
    emp_weight,
    emp_height,
    emp_head_size,
    emp_clothes_size,
    emp_pants_size,
    emp_shoe_size,
    emp_skin_color,
    emp_hair_color,
    emp_face_shape,
    emp_typical,
    emp_disabilitytype_id,
    emp_disability,
    emp_disease,
    emp_alergy,
    emp_medical_check_status,
    emp_medical_check_reason,
    emp_hobby,
    emp_pension_age,
    emp_strength,
    emp_weakness,
    emp_spare_time,
    emp_reasons_to_join,
    emp_is_applicant,
    emp_workpertype_id,
    emp_train_date,
    emp_join_date,
    emp_quit_date,
    emp_employtype_id,
    emp_workhour_id,
    emp_npwp_status,
    emp_jms_status,
    emp_healthins_status,
    emp_intins_status,
    emp_extins_status,
    emp_is_vendor,
    emp_is_customer,
    emp_status,
    emp_desc,
    emp_empstat_id,
    emp_is_locked,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    NOW()
)
";
$sql['insert_emp_email'] = "
INSERT INTO `emp_email`(
     `email_emp_id`,
     `email_emailtype_id`,
     `email_email`,
     `email_status`,
     `insert_user_id`,
     `insert_timestamp`
)VALUES (
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        NOW()
)    
";
$sql["insert_emp_status"] = "
INSERT INTO emp_employee_status
(
    empstatus_emp_id,
    empstatus_empstat_id,
    empstatus_start,
    empstatus_end,
    empstatus_decree_number,
    empstatus_decree_date,
    empstatus_decree_emp_id,
    empstatus_decree_official,
    empstatus_decree_position,
    empstatus_status,
    empstatus_desc,
    empstatus_is_default,
    empstatus_is_locked,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    NOW()
)
";
$sql["insert_emp_unit"] = "
INSERT INTO emp_employee_unit
(
    empunit_emp_id,
    empunit_unit_id,
    empunit_start,
    empunit_end,
    empunit_decree_number,
    empunit_decree_date,
    empunit_decree_emp_id,
    empunit_decree_official,
    empunit_decree_position,
    empunit_status,
    empunit_desc,
    empunit_is_default,
    empunit_is_locked,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    NOW()
)
";
$sql["insert_emp_position"] = "
INSERT INTO emp_structural_position
(
    strucpos_emp_id,
    strucpos_strucpostype_id,
    strucpos_start,
    strucpos_end,
    strucpos_decree_number,
    strucpos_decree_date,
    strucpos_decree_emp_id,
    strucpos_decree_official,
    strucpos_decree_position,
    strucpos_status,
    strucpos_desc,
    strucpos_is_default,
    strucpos_is_locked,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    NOW()
)
";
$sql["insert_emp_contract"] = "
INSERT INTO emp_employee_contract
(
    empcontract_emp_id,
    empcontract_emptype_id,
    empcontract_period,
    empcontract_period_unit,
    empcontract_start,
    empcontract_end,
    empcontract_first_reminder,
    empcontract_second_reminder,
    empcontract_third_reminder,
    empcontract_final_reminder,
    empcontract_decree_number,
    empcontract_decree_date,
    empcontract_decree_emp_id,
    empcontract_decree_official,
    empcontract_decree_position,
    empcontract_status,
    empcontract_desc,
    empcontract_is_default,
    empcontract_is_locked,
    insert_user_id,
    insert_timestamp
) VALUES (
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    %s,
    NOW()
)
";
$sql['insert_file_photo'] = "
INSERT INTO `emp_photo`(
     `photo_emp_id`,
     `photo_phototype_id`,
     `photo_file`,
     `photo_origin`,
     `photo_path`,
     `photo_type`,
     `photo_size`,
     `insert_user_id`,
     `insert_timestamp`
)VALUES (
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        NOW()
)  
";
$sql["update_employeemini"] = "
UPDATE emp_employee
SET 
    emp_number = %s,
    emp_system_code = %s,
    emp_access_code = %s,
    emp_name = %s,
    emp_first_name = %s,
    emp_middle_name = %s,
    emp_last_name = %s,
    emp_nick_name = %s,
    emp_official_name = %s,
    emp_salutation_id = %s,
    emp_title_prefix = %s,
    emp_title_sufix = %s,
    emp_birth_place = %s,
    emp_birth_date = %s,
    emp_gender = %s,
    emp_religion_id = %s,
    emp_belief = %s,
    emp_nationality_status = %s,
    emp_country_id = %s,
    emp_ethnic = %s,
    emp_dialect = %s,
    emp_bloodtype_id = %s,
    emp_weight = %s,
    emp_height = %s,
    emp_head_size = %s,
    emp_clothes_size = %s,
    emp_pants_size = %s,
    emp_shoe_size = %s,
    emp_skin_color = %s,
    emp_hair_color = %s,
    emp_face_shape = %s,
    emp_typical = %s,
    emp_disabilitytype_id = %s,
    emp_disability = %s,
    emp_disease = %s,
    emp_alergy = %s,
    emp_medical_check_status = %s,
    emp_medical_check_reason = %s,
    emp_hobby = %s,
    emp_pension_age = %s,
    emp_strength = %s,
    emp_weakness = %s,
    emp_spare_time = %s,
    emp_reasons_to_join = %s,
    emp_is_applicant = %s,
    emp_workpertype_id = %s,
    emp_train_date = %s,
    emp_join_date = %s,
    emp_quit_date = %s,
    emp_employtype_id = %s,
    emp_workhour_id = %s,
    emp_npwp_status = %s,
    emp_jms_status = %s,
    emp_healthins_status = %s,
    emp_intins_status = %s,
    emp_extins_status = %s,
    emp_is_vendor = %s,
    emp_is_customer = %s,
    emp_status = %s,
    emp_desc = %s,
    emp_empstat_id = %s,
    emp_is_locked = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE emp_id = %d
";
$sql['update_emp_email'] = "
UPDATE `emp_email`
SET
     `email_emailtype_id` = %s,
     `email_email` = %s,
     `email_status` = %s,
     `update_user_id` = %s,
     `update_timestamp` = NOW()
WHERE `email_emp_id` = %d
";
$sql["update_emp_status"] = "
UPDATE emp_employee_status
SET 
    empstatus_empstat_id = %s,
    empstatus_decree_number = %s,
    empstatus_decree_date = %s,
    empstatus_decree_emp_id = %s,
    empstatus_decree_official = %s,
    empstatus_decree_position = %s,
    empstatus_status = %s,
    empstatus_desc = %s,
    empstatus_is_default = %s,
    empstatus_is_locked = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE empstatus_emp_id = %d
";
$sql["update_emp_unit"] = "
UPDATE emp_employee_unit
SET 
    empunit_unit_id = %s,
    empunit_decree_number = %s,
    empunit_decree_date = %s,
    empunit_decree_emp_id = %s,
    empunit_decree_official = %s,
    empunit_decree_position = %s,
    empunit_status = %s,
    empunit_desc = %s,
    empunit_is_default = %s,
    empunit_is_locked = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE empunit_emp_id = %d
";
$sql["update_emp_position"] = "
UPDATE emp_structural_position
SET
    strucpos_strucpostype_id = %s,
    strucpos_decree_number = %s,
    strucpos_decree_date = %s,
    strucpos_decree_emp_id = %s,
    strucpos_decree_official = %s,
    strucpos_decree_position = %s,
    strucpos_status = %s,
    strucpos_desc = %s,
    strucpos_is_default = %s,
    strucpos_is_locked = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE strucpos_emp_id = %d
";
$sql["update_emp_contract"] = "
UPDATE emp_employee_contract
SET
    empcontract_emptype_id = %s,
    empcontract_period = %s,
    empcontract_period_unit = %s,
    empcontract_first_reminder = %s,
    empcontract_second_reminder = %s,
    empcontract_third_reminder = %s,
    empcontract_final_reminder = %s,
    empcontract_decree_number = %s,
    empcontract_decree_date = %s,
    empcontract_decree_emp_id = %s,
    empcontract_decree_official = %s,
    empcontract_decree_position = %s,
    empcontract_status = %s,
    empcontract_desc = %s,
    empcontract_is_default = %s,
    empcontract_is_locked = %s,
    update_user_id = %s,
    update_timestamp = NOW()
WHERE empcontract_emp_id = %d
";
$sql['update_file_photo'] = "
UPDATE `emp_photo`
SET
     `photo_phototype_id` = %s,
     `photo_file` = %s,
     `photo_origin` = %s,
     `photo_path` = %s,
     `photo_type` = %s,
     `photo_size` = %s,
     `update_user_id` = %s,
     `update_timestamp` = NOW()
WHERE photo_id = %d
";
$sql["delete_employeemini"] = "
DELETE FROM emp_employee
WHERE emp_id = %d
";
$sql['get_set_officer'] = "
SELECT
  `officerset_id` AS id,
  `officerset_name` AS `name`,
  `officerset_order` AS `order`,
  `officerset_status` AS `status`
FROM `set_officer_setting`
WHERE officerset_status = 1
ORDER BY officerset_order    
";
