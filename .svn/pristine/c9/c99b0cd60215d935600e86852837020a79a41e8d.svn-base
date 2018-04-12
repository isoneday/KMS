<?php
/**
 * @author Prima Noor 
 */

class DoChangePassword extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessUser', 'core.user');
        
        $result = $proses->changePassword();

        $urlRedirect = GtfwDispt()->GetUrl('core.user', 'changePassword', 'view', 'html');
        
        if ($result['status']) {
            $msg = GtfwLangText('change_password_success');
            $css = 'notebox-done';
        } else {
            if (!empty($result['err_msg']))
                $msg = $result['err_msg'];
            else
                $msg = GtfwLangText('change_password_fail');
            $css = 'notebox-warning';
        }
        
        Messenger::Instance()->Send('core.user', 'changePassword', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . $urlRedirect . '&ascomponent=1")');
        
    }
}

?>