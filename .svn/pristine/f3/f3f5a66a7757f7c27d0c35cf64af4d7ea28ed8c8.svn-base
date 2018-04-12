<?php

/**
 * @author Prima Noor 
 */
class ViewInputStatus extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_input_status.html');
    }

    function ProcessRequest() {
        $ObjStatus = GtfwDispt()->load->business('RefEmpStatus', 'emp.ref.employee.status');

        $id = Dispatcher::Instance()->Decrypt($_GET['id']->Raw());		
		unset($_SESSION['emp.ref.employee.status']['data_id']);
		
		if (!empty($id)){
			$_SESSION['emp.ref.employee.status']['data_id'] = $id;
		}	

		$elmId = $_GET['elmId']->SqlString()->Raw();
        $msg = Messenger::Instance()->Receive(__FILE__);
        $post = isset($msg[0][0]) ? $msg[0][0] : NULL;
        $message['content'] = isset($msg[0][1]) ? $msg[0][1] : NULL;
        $message['style'] = isset($msg[0][2]) ? $msg[0][2] : NULL;

        if (!empty($post)) {
            $input = $post;
        } elseif (!empty($id)) {
            $input = $ObjStatus->getDetailStatus($id);
        }

        $nav[0]['url'] = GtfwDispt()->GetUrl('emp.ref.employee.status', 'status', 'view', 'html') . '&display';
        $nav[0]['menu'] = GtfwLangText('status');
        $title = empty($id) ? GtfwLangText('add') : GtfwLangText('edit');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);

        return compact('input', 'id', 'message', 'elmId');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        $status = 'checked="checked"';
        $nstatus = '';
        $active = 'checked="checked"';
        $nactive = '';

        if (isset($input['status']) && $input['status'] != '1') {
            $status = '';
            $nstatus = 'checked="checked"';
        }

        if (isset($input['is_active']) && $input['is_active'] != '1') {
            $active = '';
            $nactive = 'checked="checked"';
        }

        if (!empty($input)) {
            $this->mrTemplate->addVars('content', $input);
        }

        $this->mrTemplate->AddVar('content', 'STATUS', $status);
        $this->mrTemplate->AddVar('content', 'NSTATUS', $nstatus);
        $this->mrTemplate->AddVar('content', 'ACTIVE', $active);
        $this->mrTemplate->AddVar('content', 'NACTIVE', $nactive);

        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('emp.ref.employee.status', 'status', 'view', 'html') . '&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('emp.ref.employee.status', (empty($id) ? 'add' : 'update') . 'Status', 'do', 'json') . '&elmId=' . $elmId);
    }

}

?>