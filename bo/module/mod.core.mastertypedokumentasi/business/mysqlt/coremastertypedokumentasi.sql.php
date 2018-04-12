<?php

$sql["count_coremastertypedokumentasi"] = "
SELECT FOUND_ROWS() AS total
";
$sql["get_coremastertypedokumentasi"] = "
SELECT 
    a.id_masdok AS `id`,
    a.nama_dokumentasi AS `nama_dokumentasi`,
    a.dekripsi_dokumentasi AS `dekripsi_dokumentasi`

FROM kms_master_type_dokumentasi a
WHERE
    1 = 1
    --search--
--limit--    
";
$sql["get_detail_coremastertypedokumentasi"] = "
SELECT 
    a.id_masdok AS `id`,
    a.nama_dokumentasi AS `nama_dokumentasi`,
    a.dekripsi_dokumentasi AS `dekripsi_dokumentasi`
FROM kms_master_type_dokumentasi a
WHERE id_masdok = %d
";
$sql["insert_coremastertypedokumentasi"] = "
INSERT INTO kms_master_type_dokumentasi
(
    nama_dokumentasi,
    dekripsi_dokumentasi
) VALUES (
    %s,
    %s
)
";
$sql["update_coremastertypedokumentasi"] = "
UPDATE kms_master_type_dokumentasi
SET 
    nama_dokumentasi = %s,
    dekripsi_dokumentasi = %s
WHERE id_masdok = %d
";
$sql["delete_coremastertypedokumentasi"] = "
DELETE FROM kms_master_type_dokumentasi
WHERE id_masdok = %d
";
$sql["list_coremastertypedokumentasi"] = "
SELECT
    id_masdok AS `id`,
    id_name AS `name`
FROM
    kms_master_type_dokumentasi
ORDER BY id_name
";