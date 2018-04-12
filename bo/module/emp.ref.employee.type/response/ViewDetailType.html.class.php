<?php

/**
 * @author Prima Noor 
 */
class ViewDetailType extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_detail_type.html');
    }

    function ProcessRequest() {
        $ObjType = GtfwDispt()->load->business('RefEmpType', 'emp.ref.employee.type');

        $id = Dispatcher::Instance()->Decrypt($_GET['id']->Raw());

        $detail = $ObjType->getDetailType($id);

        $nav[0]['url'] = GtfwDispt()->GetUrl('emp.ref.employee.type', 'type', 'view', 'html') . '&display';
        $nav[0]['menu'] = 'Type';
        $title = GtfwLangText('detail');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);

        return compact('detail');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);

        if (!empty($detail)) {
            $detail['status'] == 1 ? $detail['status'] = GtfwLangText('active') : $detail['status'] = GtfwLangText('not_active');
            $detail['is_permanent'] == 1 ? $detail['is_permanent'] = GtfwLangText('yes') : $detail['is_permanent'] = GtfwLangText('no');
            $this->mrTemplate->addVars('content', $detail);
        }
    }

}

?>