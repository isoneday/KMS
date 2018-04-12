<?php

/**
 * @author Prima Noor 
 */
class ViewInputUnit extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_input_unit.html');
    }

    function ProcessRequest() {
        $ObjUnit = GtfwDispt()->load->business('Unit', 'core.unit');

        $id = $_GET['id']->Integer()->Raw();
        $elmId = $_GET['elmId']->SqlString()->Raw();

        $msg = Messenger::Instance()->Receive(__FILE__);
        $post = isset($msg[0][0]) ? $msg[0][0] : NULL;
        $message['content'] = isset($msg[0][1]) ? $msg[0][1] : NULL;
        $message['style'] = isset($msg[0][2]) ? $msg[0][2] : NULL;

        if (!empty($post)) {
            $input = $post;
        } elseif (!empty($id)) {
            $input = $ObjUnit->getDetailUnit($id);
        }
        
        Messenger::Instance()->SendToComponent('core.unit', 'comboUnit', 'view', 'html', 'parent_id', array('dataId' => (!empty($input['parent_id']) ? $input['parent_id'] : null), 'elmId' => 'parent_id', 'first' => 'select', 'showAdd' => false, 'name' => 'parent_id', 'style' => '', 'script' => ''), Messenger::CurrentRequest);

        $nav[0]['url'] = GtfwDispt()->GetUrl('core.unit', 'unit', 'view', 'html') . '&display';
        $nav[0]['menu'] = 'Unit';
        $title = empty($id) ? GtfwLangText('add') : GtfwLangText('edit');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);

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

        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('core.unit', 'unit', 'view', 'html') . '&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('core.unit', (empty($id) ? 'add' : 'update') . 'Unit', 'do', 'json') . '&elmId=' . $elmId);
    }

}

?>