<?php
$sql['get_kategori_by_code'] = "
SELECT 
    katId AS id
FROM
    sp_golongan_kategori 
WHERE katCode = %s
"; 

$sql['add_golongan'] = "
INSERT INTO sp_golongan (
    golKategoriId,
    golKode,
    golGolongan
) 
VALUES
    (
        (SELECT 
            katId 
        FROM
            sp_golongan_kategori 
        WHERE katCode = %s),
		%s,
		%s
    )
";