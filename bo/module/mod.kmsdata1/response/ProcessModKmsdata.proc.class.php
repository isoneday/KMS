<?php
/**
 * @author Prima Noor
 */
 
class ProcessModKmsdata
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->ObjModKmsdata = GtfwDispt()->load->business('ModKmsdata');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        
        
        $Val->set_rules('data', GtfwLangText('data'), 'required');
        $Val->set_rules('kmsdata_userid', GtfwLangText('kmsdata_userid'), 'required');
        $Val->set_rules('kmsdata_idkategori', GtfwLangText('kmsdata_idkategori'), 'required');
        $Val->set_rules('kmsdata_keyword', GtfwLangText('kmsdata_keyword'), 'required');
        $Val->set_rules('filedata_enc', GtfwLangText('filedata_enc'), 'required');
        $Val->set_rules('filedata_origin', GtfwLangText('filedata_origin'), 'required');
        $Val->set_rules('filedata_path', GtfwLangText('filedata_path'), 'required');
        $Val->set_rules('filedata_type', GtfwLangText('filedata_type'), 'required');
        $Val->set_rules('filedata_size', GtfwLangText('filedata_size'), 'required');
        $Val->set_rules('upload_by', GtfwLangText('upload_by'), 'required');
        
        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjModKmsdata->StartTrans();
                $params = array(
                    $post['data'],
                    $post['kmsdata_userid'],
                    $post['kmsdata_idkategori'],
                    $post['kmsdata_keyword'],
                    $post['filedata_enc'],
                    $post['filedata_origin'],
                    $post['filedata_path'],
                    $post['filedata_type'],
                    $post['filedata_size'],
                    $post['upload_by'],
                    $this->user
                );
                $result = $result && $this->ObjModKmsdata->insertModKmsdata($params);
                $this->ObjModKmsdata->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjModKmsdata->StartTrans();
                $params = array(
                    $post['data'],
                    $post['kmsdata_userid'],
                    $post['kmsdata_idkategori'],
                    $post['kmsdata_keyword'],
                    $post['filedata_enc'],
                    $post['filedata_origin'],
                    $post['filedata_path'],
                    $post['filedata_type'],
                    $post['filedata_size'],
                    $post['upload_by'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjModKmsdata->updateModKmsdata($params);
                $this->ObjModKmsdata->EndTrans($result);   
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
            Messenger::Instance()->Send('mod.kmsdata', 'ModKmsdata', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('mod.kmsdata', 'modkmsdata', 'view', 'html');
        } else {
            Messenger::Instance()->Send('mod.kmsdata', 'inputModKmsdata', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('mod.kmsdata', (empty($post['id'])?'add':'update').'ModKmsdata', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->ObjModKmsdata->deleteModKmsdata($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('mod.kmsdata', 'ModKmsdata', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
}

?>