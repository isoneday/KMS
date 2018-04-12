<?php
/**
 * @author Prima Noor
 */
 
class ProcessKey
{
    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->Obj = GtfwDispt()->load->business('Key');;
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input()
    {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');
        
        $Val->set_rules('code', GtfwLangText('code'), 'required|callback_external_callbacks[ProcessKey,core.lang.key,checkKey]');
        
        $result = $Val->run();
        if ($result) {
            if (!$post['id']) {                
                $this->Obj->StartTrans();
                $params = array(
                    $post['code'],
                    $this->user
                );
                $result = $result && $this->Obj->insertKey($params);
				$last_id = $this->Obj->LastInsertID();
				$result = $result && $this->addKeyText($last_id,$post);
				
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
                    $this->user,
                    $post['id']
                );
                $result = $result && $this->Obj->updateKey($params);
				$result = $result && $this->Obj->deleteKeyText($post['id']);
				$result = $result && $this->addKeyText($post['id'],$post);
				
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
            Messenger::Instance()->Send('core.lang.key', 'key', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('core.lang.key', 'key', 'view', 'html');
        } else {
            Messenger::Instance()->Send('core.lang.key', 'inputKey', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('core.lang.key', (empty($post['id'])?'add':'update').'Key', 'view', 'html');
        }    
        return $result;
    }
    
    function delete($id)
    {        
        $result = TRUE;
        $this->Obj->StartTrans();
        $result = $result && $this->Obj->deleteKeyText($id);
        $result = $result && $this->Obj->deleteKey($id);
        $this->Obj->EndTrans($result);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;            
        }
        Messenger::Instance()->Send('core.lang.key', 'key', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
        //return GtfwDispt()->GetUrl('core.lang.key', 'key', 'view', 'html').'&display';
        return $result;
    }
	
	function addKeyText($last_id,$post){
		$result = true;
		if(!empty($post['lang'])){
			foreach($post['lang'] as $code=>$text){
				$params = array(
					$last_id,
					$code,
					$text,
					$this->user
				);
				
				$result = $this->Obj->insertKeyText($params);
			}
		}
		
		return $result;
	}
    
    public function checkKey($value)
    {
        $return['message'] = '';
        $return['result'] = false;
        if (!$this->Obj->checkKey($value, $_POST['id']->Integer()->Raw())) {
            $return['result'] = true;
        } else {
            $return['message'] = GtfwLangText('custom_validation_lang_key_name_been_used');
        }
        return $return;
    }
}

?>