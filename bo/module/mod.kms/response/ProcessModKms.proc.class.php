<?php
/**
 * @author Prima Noor
 */
 
class ProcessModKms
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->ObjModKms = GtfwDispt()->load->business('ModKms');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        
        
        $Val->set_rules('training', GtfwLangText('training'), 'required');
        $Val->set_rules('kmstraining_userid', GtfwLangText('kmstraining_userid'), 'required');
        $Val->set_rules('judul', GtfwLangText('judul'), 'required');
        $Val->set_rules('jenis', GtfwLangText('jenis'), 'required');
        $Val->set_rules('pembicara', GtfwLangText('pembicara'), 'required');
        $Val->set_rules('lokasi', GtfwLangText('lokasi'), 'required');
        $Val->set_rules('peserta', GtfwLangText('peserta'), 'required');
        $Val->set_rules('tanggal', GtfwLangText('tanggal'), 'required');
        $Val->set_rules('filedata_enc', GtfwLangText('filedata_enc'), 'required');
        $Val->set_rules('filedata_origin', GtfwLangText('filedata_origin'), 'required');
        $Val->set_rules('filedata_path', GtfwLangText('filedata_path'), 'required');
        $Val->set_rules('filedata_type', GtfwLangText('filedata_type'), 'required');
        $Val->set_rules('filedata_size', GtfwLangText('filedata_size'), 'required');
        $Val->set_rules('time', GtfwLangText('time'), 'required');
        
        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjModKms->StartTrans();
                $params = array(
                    $post['training'],
                    $post['kmstraining_userid'],
                    $post['judul'],
                    $post['jenis'],
                    $post['pembicara'],
                    $post['lokasi'],
                    $post['peserta'],
                    $post['tanggal'],
                    $post['filedata_enc'],
                    $post['filedata_origin'],
                    $post['filedata_path'],
                    $post['filedata_type'],
                    $post['filedata_size'],
                    $post['time'],
                    $this->user
                );
                $result = $result && $this->ObjModKms->insertModKms($params);
                $this->ObjModKms->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjModKms->StartTrans();
                $params = array(
                    $post['training'],
                    $post['kmstraining_userid'],
                    $post['judul'],
                    $post['jenis'],
                    $post['pembicara'],
                    $post['lokasi'],
                    $post['peserta'],
                    $post['tanggal'],
                    $post['filedata_enc'],
                    $post['filedata_origin'],
                    $post['filedata_path'],
                    $post['filedata_type'],
                    $post['filedata_size'],
                    $post['time'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjModKms->updateModKms($params);
                $this->ObjModKms->EndTrans($result);   
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
            Messenger::Instance()->Send('mod.kms', 'ModKms', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('mod.kms', 'modkms', 'view', 'html');
        } else {
            Messenger::Instance()->Send('mod.kms', 'inputModKms', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('mod.kms', (empty($post['id'])?'add':'update').'ModKms', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->ObjModKms->deleteModKms($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('mod.kms', 'ModKms', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
}

?>