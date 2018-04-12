<?php

class ViewHome extends HtmlResponse
{

    function TemplateModule()
    {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/'.GtfwDispt()->mModule.'/template');
        $this->SetTemplateFile('view_home.html');
    }

    function ProcessRequest()
    {
        $menuObj = GtfwDispt()->load->business("CompMenu", "comp.menu");
        
        $mId = $_GET['mId']->Integer()->Raw();
        $mmId = $_COOKIE['mmId']->Integer()->Raw();
        
        if (!empty($mId)) {
            $_SESSION['mmId'] = $mId;
        } elseif (!empty($mmId)) {
            $mId = $mmId;
        } elseif (!empty($_GET['mmId'])) {
            $mId = $_GET['mmId']->Integer()->Raw();
            $_SESSION['mmId'] = $mId;
            # set cookie
            $myDomain = preg_replace('/^[^\.]*\.([^\.]*)\.(.*)$/', '/\1.\2/', $_SERVER['HTTP_HOST']);
            $setDomain = ($_SERVER['HTTP_HOST']) != "localhost" ? ".$myDomain" : false;
            setcookie("mmId", $mId, time() + 3600 * 24 * (2), '/', "$setDomain", 0);
        } else {
            $mId = $_SESSION['mmId'];
        }
        Messenger::Instance()->Send('core.widget', 'widget', 'view', 'html', array($mId), Messenger::CurrentRequest);
        $menu = $menuObj->listMenuModule($mId);
        
        return compact('menu', 'mId');
    }

    function ParseTemplate($data = null)
    {
        extract($data);
        
        if (!empty($menu)) {
            foreach ($menu as $val) {
                if (empty($val['icon'])) {
                    $val['icon'] = 'default.png';
                }
                if (empty($val['mod'])) {
                    $val['url'] = GtfwDispt()->GetUrl('core.home', 'home', 'view', 'html').'&mId='.$val['id'];
                } else {
                    $val['url'] = GtfwDispt()->GetUrl($val['mod'], $val['sub'], $val['act'], $val['typ']).'&mId='.$val['id'];
                }
                $this->mrTemplate->addVars('icon_menu', $val);
                $this->mrTemplate->parseTemplate('icon_menu', 'a');
            }
        }
    }
}

?>
