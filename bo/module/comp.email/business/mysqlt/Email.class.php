<?php

/**
 * @author GTFW CRUD Generator 
 */
class Email extends Database {

    public function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/comp.email/business/mysqlt/email.sql.php');
        $this->SetDebugOn();
        $this->Status = Configuration::Instance()->GetValue('application', 'asset_usage_send_email'); //Set False jika pengiriman email ingin tidak diaktifkan atau true sebaliknya  
        $this->StatusSend = Configuration::Instance()->GetValue('application', 'send_email'); //Set False jika pengiriman email ingin tidak diaktifkan atau true sebaliknya  
    }

    function getDataApplication($applicationId) {
        $result = $this->Open($this->mSqlQueries['get_data_application'], array($applicationId));
        if ($result) {
            return $result[0]['name'];
        }
    }

    function getTemplateEmailDetail($file) {
        $lang = $this->Open($this->mSqlQueries['get_default_lang'], array('default_lang'));
        $isi_data = $this->Open($this->mSqlQueries['get_email_template'], array($file, $lang[0]['value']));
        if ($isi_data) {
            return $isi_data[0];
        }
    }

    public function sendEmail($to_email, $to_name, $cc, $from, $from_name, $subject, $body) {
        $ObjMail = GtfwDispt()->load->library('PHPMailer');

        $ObjMail->IsSMTP(); // telling the class to use SMTP
        #$ObjMail->SMTPDebug = 2; // enables SMTP debug information (for testing)
        # 1 = errors and messages
        # 2 = messages only
        $ObjMail->SMTPAuth = GtfwCfg('application', 'smtp_auth'); // enable SMTP authentication
        $ObjMail->Host = GtfwCfg('application', 'smtp_host'); // sets the SMTP server
        $ObjMail->Port = GtfwCfg('application', 'smtp_port'); // set the SMTP port for the GMAIL server
        $ObjMail->Username = GtfwCfg('application', 'smtp_username'); // SMTP account username
        $ObjMail->Password = GtfwCfg('application', 'smtp_password'); // SMTP account password

        $ObjMail->Priority = 1;
        $ObjMail->SetFrom($from, $from_name);
        $ObjMail->AddReplyTo(GtfwCfg('application', 'smtp_username'), GtfwCfg('application', 'smtp_username'));

        $ObjMail->Subject = $subject;
        $ObjMail->Body = $body;
        $ObjMail->IsHTML(true);
        $ObjMail->AltBody = $body; // optional, comment out and test

        if (!empty($to_email)) {            
            $ObjMail->AddAddress($to_email, $to_name);
        }

        if (!empty($cc)) {
            foreach ($cc as $key => $val) {
                $ObjMail->AddCC($val['cc_email'], $val['cc_name']);
            }
        }

        #$ObjMail->AddAddress('trinurikacahyadi@gmail.com', 'trinurikacahyadi@gmail.com');
        #$ObjMail->AddCC('trinurikacahyadi@gmail.com', 'trinurikacahyadi@gmail.com');
        #$ObjMail->AddCC('t_again@rocketmail.com', 't_again@rocketmail.com');
        #$ObjMail->AddAttachment(GtfwCfg('application', 'docroot') . "files/8ed9f1372a54b00aaed090ba12012cf4.jpg"); // attachment

        if ($this->StatusSend == true) {
            $result = $ObjMail->Send();
            $ObjMail->ClearAddresses();
            $ObjMail->IsHTML(false);
        }
        return $result;
    }

    public function sendEmailAsset($to, $from, $from_name, $cc, $subject, $body) {
        $ObjMail = GtfwDispt()->load->library('PHPMailer');

        $ObjMail->IsSMTP(); // telling the class to use SMTP
        #$ObjMail->SMTPDebug = 2; // enables SMTP debug information (for testing)
        # 1 = errors and messages
        # 2 = messages only
        $ObjMail->SMTPAuth = GtfwCfg('application', 'smtp_auth'); // enable SMTP authentication
        $ObjMail->Host = GtfwCfg('application', 'smtp_host'); // sets the SMTP server
        $ObjMail->Port = GtfwCfg('application', 'smtp_port'); // set the SMTP port for the GMAIL server
        $ObjMail->Username = GtfwCfg('application', 'smtp_username'); // SMTP account username
        $ObjMail->Password = GtfwCfg('application', 'smtp_password'); // SMTP account password

        $ObjMail->Priority = 1;
        $ObjMail->SetFrom($from, $from_name);
        $ObjMail->AddReplyTo(GtfwCfg('application', 'smtp_username'), GtfwCfg('application', 'smtp_username'));

        $ObjMail->Subject = $subject;
        $ObjMail->Body = $body;
        $ObjMail->IsHTML(true);
        $ObjMail->AltBody = $body; // optional, comment out and test

        if (!empty($to)) {
            $to_temp = array();
            foreach ($to as $key_to => $val_to) {
                $to_temp[] = $val_to['email'];
                $ObjMail->AddAddress($val_to['email'], $val_to['emp_name']);
            }
        }

        if (!empty($cc)) {
            $cc_temp = array();
            foreach ($cc as $key_cc => $val_cc) {
                if (!empty($to_temp) && (in_array($val_cc['email'], $to_temp))) {
                    unset($val_cc);
                    $val_cc = '';
                } else {
                    $val_cc = $val_cc;
                }
                $cc_temp[] = $val_cc;
            }
            if (!empty($cc_temp)) {
                $cc_temp = array_filter($cc_temp);
                foreach ($cc_temp as $key_cc_temp => $val_cc_temp) {
                    $ObjMail->AddCC($val_cc_temp['email'], $val_cc_temp['emp_name']);
                }
            }
        }

#$ObjMail->AddAddress('trinurikacahyadi@gmail.com', 'trinurikacahyadi@gmail.com');
#$ObjMail->AddCC('trinurikacahyadi@gmail.com', 'trinurikacahyadi@gmail.com');
#$ObjMail->AddCC('t_again@rocketmail.com', 't_again@rocketmail.com');
#$ObjMail->AddAttachment(GtfwCfg('application', 'docroot') . "files/8ed9f1372a54b00aaed090ba12012cf4.jpg"); // attachment

        if ($this->Status == true) {
            $result = $ObjMail->Send();
            $ObjMail->ClearAddresses();
            $ObjMail->IsHTML(false);
        }
        return $result;
    }

    function getBodyEmail($file) {
        $body = '';
        $lang = $this->Open($this->mSqlQueries['get_default_lang'], array('default_lang'));
        $isi_data = $this->Open($this->mSqlQueries['get_email_template'], array($file, $lang[0]['value']));
        if ($isi_data) {
            $isi_data = $isi_data[0]['tmpl_body'];
        } else {
            $isi_data = '';
        }
        $body .= $isi_data;

        return $body;
    }

}

// End of file EmailTemplate.class.php