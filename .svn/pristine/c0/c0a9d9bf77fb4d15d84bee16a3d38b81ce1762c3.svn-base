<?php
/**
 * @author Prima Noor
 */
 
class ProcessPrivacyPolice
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->ObjPrivacyPolice = GtfwDispt()->load->business('PrivacyPolice');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        
        
        
        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjPrivacyPolice->StartTrans();
                $params = array(
                    $post['name'],
                    $post['info'],
                    $this->user
                );
                $result = $result && $this->ObjPrivacyPolice->insertPrivacyPolice($params);
                $this->ObjPrivacyPolice->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjPrivacyPolice->StartTrans();
                $params = array(
                    $post['name'],
                    $post['info'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjPrivacyPolice->updatePrivacyPolice($params);
                $this->ObjPrivacyPolice->EndTrans($result);   
                if ($result) {
                    $msg = GtfwLangText('msg_update_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_update_fail');
                    $css = $this->cssFail;
                }             
            }
        } else {
            $msg = $Val->error_string('', '<br />');
            $css = $this->cssFail;
        }     
        if ($result) {
            Messenger::Instance()->Send('cms.privacy.police', 'PrivacyPolice', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('cms.privacy.police', 'privacypolice', 'view', 'html');
        } else {
            Messenger::Instance()->Send('cms.privacy.police', 'inputPrivacyPolice', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('cms.privacy.police', (empty($post['id'])?'add':'update').'PrivacyPolice', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->ObjPrivacyPolice->deletePrivacyPolice($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('cms.privacy.police', 'PrivacyPolice', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
}

?>