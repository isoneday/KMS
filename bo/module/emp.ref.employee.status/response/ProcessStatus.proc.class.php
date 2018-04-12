<?php

/**
 * @author Prima Noor
 */
class ProcessStatus {

    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct() {
        $this->Obj = GtfwDispt()->load->business('RefEmpStatus');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input() {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');

        $Val->set_rules('name', GtfwLangText('name'), 'required|callback_external_callbacks[ProcessStatus,emp.ref.employee.status,isNameAvailable]');        
		$Val->set_rules('order', GtfwLangText('order'), 'required|callback_external_callbacks[ProcessStatus,emp.ref.employee.status,isOrderAvailable]');

        $result = $Val->run();
        if ($result) {
            if (empty($_SESSION['emp.ref.employee.status']['data_id'])) {
                $this->Obj->StartTrans();
                $params = array(
                    $post['name'],
                    $post['is_active'],
                    $post['order'],
                    $post['status'],
                    $post['desc'],
                    $this->user
                );
                $result = $result && $this->Obj->insertStatus($params);
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
                    $post['is_active'],
                    $post['order'],
                    $post['status'],
                    $post['desc'],
                    $this->user,
                    $_SESSION['emp.ref.employee.status']['data_id']
                );
                $result = $result && $this->Obj->updateStatus($params);
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
			unset($_SESSION['emp.ref.employee.status']['data_id']);
            Messenger::Instance()->Send('emp.ref.employee.status', 'status', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('emp.ref.employee.status', 'status', 'view', 'html');
        } else {
            Messenger::Instance()->Send('emp.ref.employee.status', 'inputStatus', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('emp.ref.employee.status', (empty($post['id'])?'add':'update').'Status', 'view', 'html');
        }
        return $result;
    }

    function delete($id) {
        $result = $this->Obj->deleteStatus($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;
        }
        Messenger::Instance()->Send('emp.ref.employee.status', 'status', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);

        return $result;
    }
	
	/**
     * custom validation
     * check if name available
     * @param mixed value from post
     * @param array(mixed) optional
     * @return array of 'message' dan 'result'
     */
	
	public function isNameAvailable($value)
    {
        $return['message'] = '';
        $return['result'] = false;
        
        $param['name'] = $value;        
        if (!empty($_SESSION['emp.ref.employee.status']['data_id'])) $param['id'] = $_SESSION['emp.ref.employee.status']['data_id'];
        
        if ($this->Obj->checkField($param)) {
            $return['message'] = GtfwLangText('custom_validation_name_already_exists');
        } else {
            $return['result'] = true;
        }
        
        return $return;
    }
	
	public function isOrderAvailable($value)
    {
        $return['message'] = '';
        $return['result'] = false;
        
        $param['order'] = $value;        
        if (!empty($_SESSION['emp.ref.employee.status']['data_id'])) $param['id'] = $_SESSION['emp.ref.employee.status']['data_id'];
        
        if ($this->Obj->checkField($param)) {
            $return['message'] = GtfwLangText('custom_validation_order_already_exists');
        } else {
            $return['result'] = true;
        }
        
        return $return;
    }    
}

?>