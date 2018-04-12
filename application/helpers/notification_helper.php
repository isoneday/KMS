<?php

function send_email_notification($email, $subjek, $message_mail, $attachment) {
// Get a reference to the controller object
    $CI = & get_instance();

    $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://mail.gamatechno.com',
        'smtp_port' => '465',
        'smtp_user' => 'acsplo@gamatechno.com',
        'smtp_pass' => 'acsplo2013',
        'mailtype' => 'html',
        'starttls' => true,
        'newline' => "\r\n"
    );

    $CI->load->library('email', $config);
    $CI->email->from('beasiswa@pertaminafoundation.org', 'Beasiswa Pertamina Foundation');
    $CI->email->to($email);
    $CI->email->subject($subjek);
    $CI->email->message($message_mail);

    if ($attachment != FALSE) {
        $CI->email->attach($attachment);
    }
    $CI->email->send();

    $CI->email->print_debugger();
}

function template_email($content, $subjek) {
    $template = '<html>
    <head>
    </head>
    <body>
        <table style="background: none repeat scroll 0% 0% #6db3f2; width: 600px; padding: 15px;" align=center>
            <tr>
                <td width="100%">				
                    <table style="background-color: #fff; width: 600px; padding: 15px;" align="center">
                        <tr>
                            <td>
                                <table style="background-color: #fff; width: 600px;" align="center">
                                    <tr>
                                        <td width="200px"><img src="' . base_url() . 'img/site-logo.png" width="150px" /></td>
                                        <td width="400px"></td>
                                    </tr>
                                </table><hr style="border: 0; border-bottom: 1px dashed #ccc; background: #999;" />								
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="background-color: #fff; width: 600px;" align="center">
                                    <tr>
                                        <td>							
                                            <p style="font-family: "Open Sans",Verdana,Arial,Helvetica,sans-serif;
                                               font-weight: normal;
                                               font-size: 12px;
                                               line-height: 1.6;
                                               margin-bottom: 1.25em;
                                               text-rendering: optimizelegibility;">' . $subjek . '.<br /><br />';

    $template .= $content . '<p>		
                                        </td>
                                    </tr>
                                </table>								
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <table style="background-color: #ededed; width: 600px; text-align: center;" align="center">
                                    <tr>
                                        <td>							
                                            <p>
                                                Copyright &copy; 2016 <a href="' . base_url() . '">www.beasiswa.pertaminafoundation.org</a><br />
                                                Jl. Sinabung II, Terusan Simprug Raya, Kawasan Pertamina Learning Centre Simprug, Jakarta Selatan 12220, Telp : +6221 722 3029-32
                                            <p>		
                                        </td>
                                    </tr>
                                </table>								
                            </td>
                        </tr>
                    </table>
                    </body>
            <html>';

    return $template;
}
?>