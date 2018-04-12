<?php
/**
 * @author Prima Noor
 */
 
class ProcessCoreMastertypedokumentasi
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->ObjCoreMastertypedokumentasi = GtfwDispt()->load->business('CoreMastertypedokumentasi');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        
        
        $Val->set_rules('nama_dokumentasi', GtfwLangText('nama_dokumentasi'), 'required');
        $Val->set_rules('dekripsi_dokumentasi', GtfwLangText('dekripsi_dokumentasi'), 'required');
        
        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjCoreMastertypedokumentasi->StartTrans();
                $params = array(
                    $post['nama_dokumentasi'],
                    $post['dekripsi_dokumentasi']
                   
                );
                $result = $result && $this->ObjCoreMastertypedokumentasi->insertCoreMastertypedokumentasi($params);
                $this->ObjCoreMastertypedokumentasi->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjCoreMastertypedokumentasi->StartTrans();
                $params = array(
                    $post['nama_dokumentasi'],
                    $post['dekripsi_dokumentasi'],
                    $post['id']
                );
                $result = $result && $this->ObjCoreMastertypedokumentasi->updateCoreMastertypedokumentasi($params);
                $this->ObjCoreMastertypedokumentasi->EndTrans($result);   
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
            Messenger::Instance()->Send('mod.core.mastertypedokumentasi', 'CoreMastertypedokumentasi', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('mod.core.mastertypedokumentasi', 'coremastertypedokumentasi', 'view', 'html');
        } else {
            Messenger::Instance()->Send('mod.core.mastertypedokumentasi', 'inputCoreMastertypedokumentasi', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('mod.core.mastertypedokumentasi', (empty($post['id'])?'add':'update').'CoreMastertypedokumentasi', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->ObjCoreMastertypedokumentasi->deleteCoreMastertypedokumentasi($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('mod.core.mastertypedokumentasi', 'CoreMastertypedokumentasi', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
}

?>