<?php
/**
 * @author Prima Noor
 */
 
class ProcessCmsNews
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->ObjCmsNews = GtfwDispt()->load->business('CmsNews');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        
        
        
        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {
                $this->ObjCmsNews->StartTrans();
                $params = array(
                    $post['title'],
                    $post['content'],
                    $post['snippet'],
                    $post['photo'],
                    $post['photo_origin'],
                    $post['photo_path'],
                    $post['photo_type'],
                    $post['photo_size'],
                    $post['status'],
                    $post['newscat_id'],
                    $this->user
                );
                $result = $result && $this->ObjCmsNews->insertCmsNews($params);
                $this->ObjCmsNews->EndTrans($result);
                if ($result) {
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            } else {
                $this->ObjCmsNews->StartTrans();
                $params = array(
                    $post['title'],
                    $post['content'],
                    $post['snippet'],
                    $post['photo'],
                    $post['photo_origin'],
                    $post['photo_path'],
                    $post['photo_type'],
                    $post['photo_size'],
                    $post['status'],
                    $post['newscat_id'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->ObjCmsNews->updateCmsNews($params);
                $this->ObjCmsNews->EndTrans($result);   
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
            Messenger::Instance()->Send('cms.news', 'CmsNews', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('cms.news', 'cmsnews', 'view', 'html');
        } else {
            Messenger::Instance()->Send('cms.news', 'inputCmsNews', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('cms.news', (empty($post['id'])?'add':'update').'CmsNews', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->ObjCmsNews->deleteCmsNews($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('cms.news', 'CmsNews', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
}

?>