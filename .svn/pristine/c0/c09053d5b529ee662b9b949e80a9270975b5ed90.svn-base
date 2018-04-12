<?php

$sql['get_module_menu_id'] = "
SELECT
  `module_menu_id` AS menu_id
FROM `gtfw_module`
WHERE
  `module` = %s
  AND `module_sub_module` = %s
  AND `module_action`= %s
  AND `module_type` = %s
";

$sql['get_presentase_kegagalan'] = "
SELECT
	FLOOR(r.lost/r.total*100) AS percent
FROM (
	SELECT 
		SUM(IF(a.opportunity_prospectstage_id = 9,1,0)) AS lost,
		COUNT(a.opportunity_id) AS total
	FROM crm_opportunity a
	WHERE
		1 = 1
) r
";

$sql['get_barang_masuk_keluar'] = "
SELECT
	r.bulan,
	SUM(IF(s.stockin_qty_minus = 0,1,0)) AS masuk,
	SUM(IF(s.stockin_qty_plus = 0,1,0)) AS keluar
FROM (
	SELECT 
		LPAD(a.bulan,2,'0') AS bulan,
		%s AS tahun
	FROM (
		SELECT '12' - (A.A + (10 * B.A)) AS bulan
		FROM (SELECT 0 AS A UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS A
		CROSS JOIN (SELECT 0 AS A UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS B
	) a
	WHERE a.bulan BETWEEN '01' AND '12'
	ORDER BY a.bulan
) r
LEFT JOIN pcs_stock_in_out s ON MONTH(s.stockin_date) = r.bulan AND YEAR(s.stockin_date) = r.tahun
GROUP BY r.bulan
";