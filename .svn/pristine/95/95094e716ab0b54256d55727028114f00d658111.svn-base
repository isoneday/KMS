<?php

/**
 * @author Prima Noor 
 */
class ViewInputType extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_input_type.html');
    }

    function ProcessRequest() {
        $ObjType = GtfwDispt()->load->business('RefEmpType', 'emp.ref.employee.type');

        $id = Dispatcher::Instance()->Decrypt($_GET['id']->Raw());		
		unset($_SESSION['emp.ref.employee.type']['data_id']);
		
		if (!empty($id)){
			$_SESSION['emp.ref.employee.type']['data_id'] = $id;
		}
		
        $elmId = $_GET['elmId']->SqlString()->Raw();
        $msg = Messenger::Instance()->Receive(__FILE__);
        $post = isset($msg[0][0]) ? $msg[0][0] : NULL;
        $message['content'] = isset($msg[0][1]) ? $msg[0][1] : NULL;
        $message['style'] = isset($msg[0][2]) ? $msg[0][2] : NULL;

        if (!empty($post)) {
            $input = $post;
        } elseif (!empty($id)) {
            $input = $ObjType->getDetailType($id);
        }

        $nav[0]['url'] = GtfwDispt()->GetUrl('emp.ref.employee.type', 'type', 'view', 'html') . '&display';
        $nav[0]['menu'] = GtfwLangText('type');
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
        $permanent = 'checked="checked"';
        $npermanent = '';

        if (isset($input['status']) && $input['status'] != '1') {
            $status = '';
            $nstatus = 'checked="checked"';
        }

        if (isset($input['is_permanent']) && $input['is_permanent'] != '1') {
            $permanent = '';
            $npermanent = 'checked="checked"';
        }

        if (!empty($input)) {
            $this->mrTemplate->addVars('content', $input);
        }

        $this->mrTemplate->AddVar('content', 'STATUS', $status);
        $this->mrTemplate->AddVar('content', 'NSTATUS', $nstatus);
        $this->mrTemplate->AddVar('content', 'PERMANENT', $permanent);
        $this->mrTemplate->AddVar('content', 'NPERMANENT', $npermanent);

        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('emp.ref.employee.type', 'type', 'view', 'html') . '&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('emp.ref.employee.type', (empty($id) ? 'add' : 'update') . 'Type', 'do', 'json') . '&elmId=' . $elmId);
    }

}

?>