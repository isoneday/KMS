<?php

class ViewBreadcrump extends HtmlResponse
{

    var $mComponentParameters;

    function TemplateModule()
    {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/comp.breadcrump/template');
        $this->SetTemplateFile('view_breadcrump.html');
    }

    function ProcessRequest()
    {
        $msg = Messenger::Instance()->Receive(__file__, $this->mComponentName);
        
        if (!empty($msg)) {
            $return['currentNama'] = $msg[0][0];
            $return['arrData'] = $msg[0][1];
            $return['id'] = $msg[0][2];
            $return['all'] = $msg[0][3];
            $return['action'] = $msg[0][4];
        } else {
            $return['currentNama'] = '';
            $return['arrData'] = array();
            $return['id'] = '';
            $return['all'] = '';
            $return['action'] = '';
            $ObjBreadcrumb = GtfwDispt()->load->business('Breadcrumb', 'comp.breadcrump');
            
            $param = array(
                Dispatcher::Instance()->mModule,
                Dispatcher::Instance()->mSubModule,
                Dispatcher::Instance()->mAction,
                Dispatcher::Instance()->mType);
            
            $menuDetail = $ObjBreadcrumb->getMenuDetail($param);
            
            $homeUrl = GtfwDispt()->GetUrl('core.home', 'home', 'view', 'html');
            
            if (!empty($menuDetail)) {                
                $menus = $ObjBreadcrumb->getPath($menuDetail['menu_id'], GtfwLang()->GetLangCode());
                
                if (!empty($menus)) {
                    foreach ($menus as $val) {
                        $return['arrData'][] = array(
                            'url' => (empty($val['mod'])OR($val['mod']=='core.home' AND $val['sub']=='home'))?($homeUrl.'&mId='.$val['menu_id']):(GtfwDispt()->GetUrl($val['mod'], $val['sub'], $val['act'], $val['typ']).'&display'),
                            'menu' => $val['title']
                        );
                    }
                }
                if (!empty($menuDetail['action'])) {
                    $return['currentNama'] = (!empty($msg[0]['title']))?$msg[0]['title']:$menuDetail['action'];
                } else {
                    unset($return['arrData'][count($return['arrData'])-1]);
                    $return['currentNama'] = $menuDetail['title'];
                }
            }
            
        }
        
        return $return;
    }

    function ParseTemplate($data = null)
    {
        if (!empty($data)) {
            $mTemplate = "breadcrump_nav_item";
            $mTemplateID = "NAV";
            $mArray = $data["arrData"];
            $mAll = $data["all"];

            $this->mrTemplate->addVar("breadcrump_nav", "ACTION", $data["action"]);
            $this->mrTemplate->addVar("breadcrump_nav", "NAV_TITLE", $data["currentNama"]);

            for ($i = 0; $i < sizeof($mArray); $i++) {
                if ($mAll == "hidden") {
                    $this->mrTemplate->SetAttribute("$mTemplate", 'visibility', 'hidden');
                } else {
                    $this->mrTemplate->SetAttribute("$mTemplate", 'visibility', 'visible');
                }
                if (isset($mArray[$i]['menu']))
                    $this->mrTemplate->addVar("$mTemplate", $mTemplateID . "_MENU", $mArray[$i]['menu']);
                if (isset($mArray[$i]['url']))
                    $this->mrTemplate->addVar("$mTemplate", $mTemplateID . "_URL", $mArray[$i]['url']);
                $this->mrTemplate->parseTemplate("$mTemplate", "a");
            }
            $this->mrTemplate->addVar('breadcrump_nav', 'URL_HOME', GtfwDispt()->GetUrl('core.home', 'home', 'view', 'html'));
        }
    }

}

?>
