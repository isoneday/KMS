<?php
/**
 * @author Prima Noor
 */
 
class ProcessDocumentation
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->Obj = GtfwDispt()->load->business('Documentation');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $dependency_source = array();
        $dependency_target = array();
        
        if (!empty($post['source_tables'])) {
            foreach ($post['source_tables'] as $key => $val) {
                $dependency_source[] = $val.'|'.$post['source_fields'][$key];
            }
        }
        $dependency_source = implode(',', $dependency_source);
        
        if (!empty($post['target_tables'])) {
            foreach ($post['target_tables'] as $key => $val) {
                $dependency_target[] = $val.'|'.$post['target_fields'][$key];
            }
        }
        $dependency_target = implode(',', $dependency_target);
        
        $Val = GtfwDispt()->load->library('Validation');
        
        
        
        $result = $Val->run();
        if ($result) {
            if (empty($post['id'])) {
                $this->Obj->StartTrans();
                $params = array(
                    $post['name'],
                    $post['table'],
                    $dependency_source,
                    $dependency_target,
                    $post['desc'],
                    $post['sample_data'],
                    $post['menu_name'],
                    $post['module_name'],
                    $this->user
                );
                $result = $result && $this->Obj->insertDocumentation($params);
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
                    $post['name'],
                    $post['table'],
                    $dependency_source,
                    $dependency_target,
                    $post['desc'],
                    $post['sample_data'],
                    $post['menu_name'],
                    $post['module_name'],
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->Obj->updateDocumentation($params);
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
            Messenger::Instance()->Send('core.table.documentation', 'documentation', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('core.table.documentation', 'documentation', 'view', 'html');
        } else {
            Messenger::Instance()->Send('core.table.documentation', 'inputDocumentation', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('core.table.documentation', (empty($post['id'])?'add':'update').'Documentation', 'view', 'html');
        }
        return $result;     
    }
    
    function delete($id)
    {
        $result = $this->Obj->deleteDocumentation($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('core.table.documentation', 'documentation', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        
        return $result;
    }
}

?>