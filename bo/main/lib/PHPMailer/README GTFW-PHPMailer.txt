README GTFW - PHPMailer 

Tambahkan Parameter pada configuration file:

$application['smtp_email'] = true; //default true. set true jika menggunakan smtp mail server, false jika menggunakan internal local sendmail server 
$application['smtp_host'] = 'mail.server.com'; // server mail. Misal : smtp.googlemail.com
$application['smtp_port'] = '587'; // port smtp
$application['smtp_secure'] = 'tls'; // Prefix smtp Security, misal : ssl, tls, etc.
$application['smtp_auth'] = true; // set true jika mail server menggunakan smtp Authentication
$application['smtp_username'] = 'email@server.com'; //username 
$application['smtp_password'] = 'emailpassword'; //password


Penggunaan (Pada Response atau Proses): 

// Load Library PHPMailer
$objMail = GtfwDispt()->load->library('PHPMailer');

//lihat keterangan $application['smtp_email'] diatas
if (GTFWConfiguration::GetValue('application', 'smtp_email') == true) {
    $objMail->IsSMTP();
    //$objMail->SMTPDebug = 1; //untuk smtp debugging 
    $objMail->SMTPAuth = GTFWConfiguration::GetValue('application', 'smtp_auth');
    $objMail->Host = GTFWConfiguration::GetValue('application', 'smtp_host');
    $objMail->Port = GTFWConfiguration::GetValue('application', 'smtp_port');
    $objMail->Username = GTFWConfiguration::GetValue('application', 'smtp_username');
    $objMail->Password = GTFWConfiguration::GetValue('application', 'smtp_password');
    $objMail->SMTPSecure = GTFWConfiguration::GetValue('application', 'smtp_secure') == '' ? 'tls' : GTFWConfiguration::GetValue('application', 'smtp_secure');
}

$objMail->SetFrom("pengirim@emailnya.com", "Nama Pengirim"); // set alamat email dan nama pengirim

//$objMail->AddReplyTo('replyto@emailnya.com', 'Nama Reply To'); //opsional, jika email baasan berbeda dengan email pengirim

$objMail->Subject = "Subject Email"; // set subject email

$objMail->MsgHTML("Isi Email Dalam HTML"); // Isi email bisa berupa plain text atau html.

//$objMail->AltBody = "Isi Email Berupa Plain Text"; // Opsional. isi dengan plain text. sebagai alternatif jika mail client penerima tidak support html.

$objMail->AddAddress("penerima1@email.com", "Nama Penerima 1"); // set email dan nama penerima.
//$objMail->AddAddress("penerima2@email.com", "Nama Penerima 2"); // optional jika ada penerima ke dua, dst. set email dan nama penerima. 
//$objMail->AddAddress("penerima3@email.com", "Nama Penerima 3"); // optional jika ada penerima ke dua, dst. set email dan nama penerima.

//$objMail->AddCC("penerimacc1@email.com", "Nama Penerima 1"); // opsional jika ada cc. set email dan nama penerima.
//$objMail->AddCC("penerimacc2@email.com", "Nama Penerima 2"); // optional jika ada cc ke dua, dst. set email dan nama penerima. 
//$objMail->AddCC("penerimacc3@email.com", "Nama Penerima 3"); // optional jika ada cc ke dua, dst. set email dan nama penerima.

//$objMail->AddBCC("penerimabcc1@email.com", "Nama Penerima 1"); // opsional jika ada bcc. set email dan nama penerima.
//$objMail->AddBCC("penerimabcc2@email.com", "Nama Penerima 2"); // optional jika ada bcc ke dua, dst. set email dan nama penerima. 
//$objMail->AddBCC("penerimabcc3@email.com", "Nama Penerima 3"); // optional jika ada bcc ke dua, dst. set email dan nama penerima.

//$objMail->AddAttachment('dokumen/laporan1.pdf'); //opsional jika ada attachment. Set Path File
//$objMail->AddAttachment('dokumen/laporan2.pdf'); //opsional jika ada attachment ke dua , dst. Set Path File

if($objMail->Send()){
  // mail terkirim
}else{
  echo $this->objMail->ErrorInfo // 
}


//selesai.
//Untuk Method method lebih lanjut mengenai Library PHPMailer ini silakan baca baca dokumantasi PHPMailer.