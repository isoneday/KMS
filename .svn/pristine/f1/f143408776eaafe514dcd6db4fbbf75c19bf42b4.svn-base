<?php

$sql['update_book'] = "
UPDATE 
    sp_buku_agama 
SET
    bkPenerbit = %s
WHERE bkJudul = %s
";

$sql['get_golongan_id'] = "
SELECT 
    golId AS id
FROM
    sp_golongan 
WHERE golKode = %s
";

$sql['get_seksi_id'] = "
SELECT 
    seksiId AS id
FROM
    sp_seksi 
WHERE seksiKode = %s
";

$sql['get_tingkat_id'] = "
SELECT 
    tingkatId AS id
FROM
    sp_tingkat 
WHERE tingkatKode = %s
";

$sql['add_seksi'] = '
insert into sp_seksi (
    seksiKode,
    seksiKeterangan
) 
values
    (
    %1$s, %1$s
    ) 
';

$sql['get_penerbit_id'] = "
SELECT
    penerbitId AS id
FROM sp_penerbit
WHERE
    penerbitNama = %s
";

$sql['add_penerbit'] = "
INSERT INTO sp_penerbit (
    penerbitNama
) 
VALUES
    (
		%s
    )
";