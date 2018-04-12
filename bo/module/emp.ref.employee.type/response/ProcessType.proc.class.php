<?php

/**
 * @author Prima Noor
 */
class ProcessType {

    var $Obj;
    var $user;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct() {
        $this->Obj = GtfwDispt()->load->business('RefEmpType');
        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
    }

    function input() {
        $post = $_POST->AsArray();
        $Val = GtfwDispt()->load->library('Validation');

        $Val->set_rules('name', GtfwLangText('name'), 'required|callback_external_callbacks[ProcessType,emp.ref.employee.type,isNameAvailable]');
        $Val->set_rules('order', GtfwLangText('order'), 'required|callback_external_callbacks[ProcessType,emp.ref.employee.type,isOrderAvailable]');
		//$Val->set_rules('order', GtfwLangText('order'), 'required');

        $result = $Val->run();
        if ($result) {
            if (empty($_SESSION['emp.ref.employee.type']['data_id'])) {
                $this->Obj->StartTrans();
                $params = array(
                    $post['name'],
                    $post['is_permanent'],
                    $post['order'],
                    $post['status'],
                    $post['desc'],
                    $this->user
                );
                $result = $result && $this->Obj->insertType($params);
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
                    $post['is_permanent'],
                    $post['order'],
                    $post['status'],
                    $post['desc'],
                    $this->user,
                    $_SESSION['emp.ref.employee.type']['data_id']
                );
                $result = $result && $this->Obj->updateType($params);
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
			unset($_SESSION['emp.ref.employee.type']['data_id']);
            Messenger::Instance()->Send('emp.ref.employee.type', 'type', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('emp.ref.employee.type', 'type', 'view', 'html');
        } else {
            Messenger::Instance()->Send('emp.ref.employee.type', 'inputType', 'view', 'html', array($post, $msg, $css), Messenger::NextRequest);
            //return Dispatcher::Instance()->GetUrl('emp.ref.employee.type', (empty($post['id'])?'add':'update').'Type', 'view', 'html');
        }
        return $result;
    }

    function delete($id) {
        $result = $this->Obj->deleteType($id);
        if ($result) {
            $msg = GtfwLangText('msg_delete_success');
            $css = $this->cssDone;
        } else {
            $msg = GtfwLangText('msg_delete_fail');
            $css = $this->cssFail;
        }
        Messenger::Instance()->Send('emp.ref.employee.type', 'type', 'view', 'html', array(NULL, $msg, $css), Messenger::NextRequest);

        return $result;
    }
	
	public function isNameAvailable($value)
    {
        $return['message'] = '';
        $return['result'] = false;
        
        $param['name'] = $value;        
        if (!empty($_SESSION['emp.ref.employee.type']['data_id'])) $param['id'] = $_SESSION['emp.ref.employee.type']['data_id'];
        
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
        if (!empty($_SESSION['emp.ref.employee.type']['data_id'])) $param['id'] = $_SESSION['emp.ref.employee.type']['data_id'];
        
        if ($this->Obj->checkField($param)) {
            $return['message'] = GtfwLangText('custom_validation_order_already_exists');
        } else {
            $return['result'] = true;
        }
        
        return $return;
    }

}

?>