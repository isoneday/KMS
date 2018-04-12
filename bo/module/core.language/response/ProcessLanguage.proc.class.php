<?php
/**
 * @author Prima Noor
 */
 
class ProcessLanguage
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->Obj = GtfwDispt()->load->business('Language');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        
        
        $Val->set_rules('code', 'Code', 'required');
        
        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->Obj->StartTrans();
                $params = array(
                    $post['code'],
                    $post['name'],
                    $post['icon_path'],
                    $post['description'],
                    $this->user
                );
                $result = $result && $this->Obj->insertLanguage($params);
                $this->Obj->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->Obj->StartTrans();
                $params = array(
                    $post['code'],
                    $post['name'],
                    $post['icon_path'],
                    $post['description'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->Obj->updateLanguage($params);
                $this->Obj->EndTrans($result);   
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
            Messenger::Instance()->Send('core.language', 'language', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('core.language', 'language', 'view', 'html');
        } else {
            Messenger::Instance()->Send('core.language', 'inputLanguage', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('core.language', (empty($post['id'])?'add':'update').'Language', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->Obj->deleteLanguage($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('core.language', 'language', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
}

?>