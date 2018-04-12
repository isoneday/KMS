SELECT a.pembayaran_id AS `id`,  
    c.`user_real_name` AS `aplikanid`,
      (SELECT user_real_name FROM gtfw_user WHERE a.`pembayaran_userid` = gtfw_user.`user_id` ) AS 'userid',       
    a.`pembayaran_bankpengirim` AS `bankpengirim`,
    a.pembayaran_nobankpengirim AS `nobankpengirim`,
    a.pembayaran_bankpenerima AS `bankpenerima`,
    a.pembayaran_nobankpenerima AS `nobankpenerima`,
   a.pembayaran_semester AS `semester`,
    a.pembayaran_tanggal AS `tanggal`,
    a.pembayaran_keterangan AS `keterangan`,
    a.pembayaran_timestamp AS `timestamp`    
  FROM beasiswa_pembayaran a
    LEFT JOIN aplikan_user b ON b.`aplikan_id`=a.`pembayaran_aplikanid` LEFT JOIN gtfw_user c ON c.`user_id`=b.`user_id`
