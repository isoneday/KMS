<?php

class ViewMsgContainer extends HtmlResponse {
    function TemplateModule() {
        $this->SetTemplateBasedir('module/' . Dispatcher::Instance()->mModule . '/template');
        $this->SetTemplateFile('view_msg_container.html');
    }

    function ProcessRequest() {
        $Obj = GtfwDispt()->load->business('CompMessage', 'comp.message');

        // Generate data
        $folderList = $Obj->listFolder();

        if (!isset($_GET['folderId']))
            $folderId = 1;
        else
            $folderId = $_GET['folderId']->Float()->Raw();
        // --------- //

        // Generate url
        $url = array();
        $url['new'] = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, 'newMessage', 'view', 'html');
        $url['setting'] = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, 'setting', 'view', 'html');
        $url['folder'] = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, 'folderContent', 'view', 'html');
        $url['check'] = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, 'countNewMessage', 'do', 'json');
        // --------- //

        // inisialisi breadcrump
        $nav[0]['url'] = "";
        $nav[0]['menu'] = "";
        $title = GtfwLangText('messaging');

        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array(
            $title,
            $nav,
            'breadcrump',
            'hidden',
            ''), Messenger::CurrentRequest);
        // --------- //

        return compact('folderList', 'folderId', 'url');
    }

    function ParseTemplate($data = null) {
        extract($data);

        $this->mrTemplate->AddVar('content', 'folderId', $folderId);
        $this->mrTemplate->AddVars('content', $url, 'URL_');
        foreach ($folderList as $folder) {
            $folder['url_folder'] = "$url[folder]&folderId=$folder[folder_id]";
            $folder['folder_name'] = addslashes($folder['folder_name']);
            $this->mrTemplate->AddVars('folder_content', $folder);
            $this->mrTemplate->ParseTemplate('folder_content', 'a');
        }
        
        $this->mrTemplate->addVar('content', 'AUTO_CHECK_MESSAGE', GtfwCfg('application', 'autoload_notif')?'true':'false');
    }
}

?>
