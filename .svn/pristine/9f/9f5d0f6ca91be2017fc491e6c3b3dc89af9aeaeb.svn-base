<?php

/**
 * @author Prima Noor 
 */
class ViewInputCoreGroupall extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_input_coregroupall.html');
    }

    function ProcessRequest() {
        $ObjCoreGroupall = GtfwDispt()->load->business('CoreGroupall', 'core.groupall');

        $id = $_GET['id']->Integer()->Raw();
        $elmId = $_GET['elmId']->SqlString()->Raw();

        $msg = Messenger::Instance()->Receive(__FILE__);
        $post = isset($msg[0][0]) ? $msg[0][0] : NULL;
        $message['content'] = isset($msg[0][1]) ? $msg[0][1] : NULL;
        $message['style'] = isset($msg[0][2]) ? $msg[0][2] : NULL;

        if (!empty($post)) {
            Messenger::Instance()->Send('core.groupall', 'hakAkses', 'view', 'html', array($post), Messenger::NextRequest);
            unset($post['access']);
            unset($post['action']);
            $input = $post;
        } elseif (!empty($id)) {
            $input = $ObjCoreGroupall->getDetailCoreGroupall($id);
        }
        
        $list_app = $ObjCoreGroupall->listApplication();
        Messenger::Instance()->SendToComponent('comp.combobox', 'Combobox', 'view', 'html', 'application_id', array(
            'application_id',
            $list_app,
            !empty($input['application_id']) ? $input['application_id'] : NULL,
            '',
            ' tabindex="3"'), Messenger::CurrentRequest);

        return compact('input', 'id', 'message', 'elmId');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        if (!empty($input)) {
            $this->mrTemplate->addVars('content', $input);
        }

        $this->mrTemplate->addVar('content', 'URL_HAK_AKSES', GtfwDispt()->GetUrl('core.groupall', 'hakAkses', 'view', 'html'));
        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('core.groupall', 'CoreGroupall', 'view', 'html') . '&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('core.groupall', (empty($id) ? 'add' : 'update') . 'CoreGroupall', 'do', 'json') . '&elmId=' . $elmId);
    }

}

?>