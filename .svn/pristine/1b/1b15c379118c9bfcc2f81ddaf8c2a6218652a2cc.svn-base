<?php
/**
 * @author Prima Noor
 */
 
class ProcessCompanyProfile
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->ObjCompanyProfile = GtfwDispt()->load->business('CompanyProfile');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        
        
        
        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjCompanyProfile->StartTrans();
                $params = array(
                    $post['title'],
                    $post['content'],
                    $this->user
                );
                $result = $result && $this->ObjCompanyProfile->insertCompanyProfile($params);
                $this->ObjCompanyProfile->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjCompanyProfile->StartTrans();
                $params = array(
                    $post['title'],
                    $post['content'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjCompanyProfile->updateCompanyProfile($params);
                $this->ObjCompanyProfile->EndTrans($result);   
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
            Messenger::Instance()->Send('cms.company.profile', 'CompanyProfile', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('cms.company.profile', 'companyprofile', 'view', 'html');
        } else {
            Messenger::Instance()->Send('cms.company.profile', 'inputCompanyProfile', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('cms.company.profile', (empty($post['id'])?'add':'update').'CompanyProfile', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->ObjCompanyProfile->deleteCompanyProfile($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('cms.company.profile', 'CompanyProfile', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
}

?>