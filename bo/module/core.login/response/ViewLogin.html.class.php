<?php

class ViewLogin extends HtmlResponse {

    var $login_page;

    function TemplateBase() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'main/template/');
        $this->SetTemplateFile('document-login.html');
        $this->SetTemplateFile('layout-login.html');
    }

    function TemplateModule() {
        $this->login_page = GtfwCfg('application', 'login_page');
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . $this->login_page['mod'] . '/template');
        $this->SetTemplateFile('view_login.html');
    }

    function ProcessRequest() {
//        echo "<pre>";
//        print_r(Session::Instance()->data_decode("c3RhcnRfa2V5fGk6OTk4MjEyNjk5O211bHRfa2V5fGk6MTYzNTg5MjQ3NjthZGRfa2V5fGk6ODQ3MDg1NzQ7aXNfbG9nZ2VkX2lufGI6MDt1c2VybmFtZXxzOjY6Im5vYm9keSI7c2FsdHxpOjIwMjUwOTU2NTM7bG9naW5fc2FsdHxpOjIwMjUwOTU2NTM7"));
//        echo "<pre>";
//        exit;
//        
        if (Security::Instance()->IsLoggedIn()) {
            $home = GtfwCfg('application', 'default_page');
            $urlHome = Dispatcher::Instance()->GetUrl($home['mod'], $home['sub'], $home['act'], $home['typ']);
            // redirect to proper place
            $this->RedirectTo($urlHome);
            return null;
        }
 $url = Dispatcher::Instance()->GetUrl(Dispatcher::Instance()->mModule, Dispatcher::Instance()->mSubModule, Dispatcher::Instance()->mAction, Dispatcher::Instance()->mType);
        Messenger::Instance()->SendToComponent('core.login', 'login', 'view', 'html', 'paging_top', array(
            $display,
            $total,
            $url,
            $page), Messenger::CurrentRequest);
       
        $detect = null;

        return Security::Instance()->RequestSalt();
    }

    function ParseTemplate($data = null) {
        
        if (!empty($message)) {
            $this->mrTemplate->addVar('message', $message);
        }

        $this->mrTemplate->addVar('content', 'URL_ACTION', GtfwDispt()->GetUrl($this->login_page['mod'], 'login', 'do', 'html'));
        $this->mrTemplate->AddVar('document', 'LOADER_NAME_ADDITONAL', '-login');
        $_SESSION['login_salt'] = $data;
        if (!isset($_GET['fail'])) {

            $this->SetBodyAttribute('onload', '"document.form_login.username.focus();"');
      //  $this->mrTemplate->AddVar('content', 'LOGIN_GAGAL');
       // echo "maaf gagagl"; 
        }
     
        $this->mrTemplate->AddVar('head_addition', 'APP_BASE_ADDRESS', Configuration::Instance()->GetValue('application', 'baseaddress') . Configuration::Instance()->GetValue('application', 'basedir'));
        $this->mrTemplate->AddVar('content', 'LOGIN_SALT', $data);
    }

}

?>
