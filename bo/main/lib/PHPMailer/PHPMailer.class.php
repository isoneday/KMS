<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SMS untuk mengirim sms yoo
 * config ngambil dari application config
 * @author devel
 */
require_once 'PHPMailer.php';

class GT_PHPMailer {

    //put your code here

    protected $email;
    protected $emailsender;
    protected $username;
    protected $password;
    protected $smtp;
    protected $smtpport;
    protected $smtpauth;
    protected $smtispauth;
    public $emailtujuan;
    public $meesage;

    function __construct() {
//       $this->baseurl=Configuration::Instance()->GetValue('application', 'sms_base_url');
//       $this->session_file=Configuration::Instance()->GetValue('application', 'sms_session_file');
//       $this->username=Configuration::Instance()->GetValue('application', 'sms_username');
//       $this->password=Configuration::Instance()->GetValue('application', 'sms_password');

        $this->email = Configuration::Instance()->GetValue('application', 'akun_email');
        $this->semailsender = Configuration::Instance()->GetValue('application', 'email_sender');
        $this->username = Configuration::Instance()->GetValue('application', 'smtp_username');
        $this->password = Configuration::Instance()->GetValue('application', 'smtp_password');
        $this->smtp = Configuration::Instance()->GetValue('application', 'smtp_host');
        $this->smtpport = Configuration::Instance()->GetValue('application', 'smtp_port');
        $this->smtpauth = Configuration::Instance()->GetValue('application', 'smtp_secure');
        $this->smtispauth = Configuration::Instance()->GetValue('application', 'smtp_auth');
    }

    public function sentEmail($email, $subjek, $message) {
        $objMail = new PHPMailer();
        if (Configuration::Instance()->GetValue('application', 'send_email') == true) {
            $objMail->IsSMTP();
            //$objMail->SMTPDebug = 2; //untuk smtp debugging
            $objMail->SMTPAuth = $this->smtispauth;
            $objMail->Host = $this->smtp;
            $objMail->Port = $this->smtpport;
            $objMail->Username = $this->username;
            $objMail->Password = $this->password;
            $objMail->Subject = $subjek;
			//echo $this->semailsender; die();
            //$objMail->SMTPSecure = $this->smtpauth == '' ? 'tls' : $this->smtpauth;
             $mail = $objMail;
            $mail->SetFrom($this->semailsender, 'Beasiswa Pertamina Foundation');
            $mail->MsgHTML($message);
            $mail->AddAddress($email, "no-reply@pertaminafoundation.org");
			
            if (!$mail->Send()) {
                return false;
            } else {
                return true;
            }
        }
       
    }

}
?>

