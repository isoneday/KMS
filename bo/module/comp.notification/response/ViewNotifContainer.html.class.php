<?php

/**
 * @author Prima Noor 
 */
class ViewNotifContainer extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/comp.notification/template');
        $this->SetTemplateFile('view_notif_container.html');
    }

    function ProcessRequest() {
        $ObjNotif = GtfwDispt()->load->business('Notification', 'comp.notification');

        $notification = $ObjNotif->getOldNotification();

        $url = array();
        $url['update'] = GtfwDispt()->GetUrl('comp.notification', 'getNotif', 'do', 'json');

        return compact('notification', 'url');
    }

    function ParseTemplate($rdata = null) {
        extract($rdata);

        $this->mrTemplate->AddVars('content', $url, 'URL_');
        
        $this->mrTemplate->addVar('content', 'AUTO_NOTIF', GtfwCfg('application', 'autoload_notif') ? 'true' : 'false');

        if (empty($notification))
            return;
        $this->mrTemplate->SetAttribute('oldNotification', 'visibility', 'visible');
        while ($data = array_pop($notification)) {
            $this->mrTemplate->AddVars('oldNotification', $data);
            $this->mrTemplate->ParseTemplate('oldNotification', 'a');
        }
    }

}

?>