<?php

/**
 * @author Prima Noor 
 */
class ViewDetailStatus extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_detail_status.html');
    }

    function ProcessRequest() {
        $ObjStatus = GtfwDispt()->load->business('RefEmpStatus', 'emp.ref.employee.status');

        $id = Dispatcher::Instance()->Decrypt($_GET['id']->Raw());

        $detail = $ObjStatus->getDetailStatus($id);

        $nav[0]['url'] = GtfwDispt()->GetUrl('emp.ref.employee.status', 'status', 'view', 'html') . '&display';
        $nav[0]['menu'] = 'Status';
        $title = GtfwLangText('detail');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);

        return compact('detail');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);

        if (!empty($detail)) {
            $detail['status'] == 1 ? $detail['status'] = GtfwLangText('active') : $detail['status'] = GtfwLangText('not_active');
            $detail['is_active'] == 1 ? $detail['is_active'] = GtfwLangText('yes') : $detail['is_active'] = GtfwLangText('no');
            $this->mrTemplate->addVars('content', $detail);
        }
    }

}

?>