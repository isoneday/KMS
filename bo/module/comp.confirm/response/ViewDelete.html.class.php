<?php

class ViewDelete extends HtmlResponse
{

    function TemplateModule()
    {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/comp.confirm/template');
        $this->SetTemplateFile('view_delete.html');
    }

    function ProcessRequest()
    {
        if (!empty($_POST['id'])) {
            $_POST = $_POST->AsArray();
            $msg = Messenger::Instance()->Receive(__file__);
            $return[0]['label'] = isset($msg[0][0])?$msg[0][0]:NULL;
            $return[0]['urlDelete'] = isset($msg[0][1])?$msg[0][1]:NULL;
            $return[0]['urlReturn'] = isset($msg[0][2])?$msg[0][2]:NULL;

            for ($i = 0; $i < sizeof($_POST['id']); $i++) {
                $return[$i]['id'] = $_POST['id'][$i];
                $return[$i]['dataname'] = $_POST['name'][$_POST['id'][$i]];
                if (!empty($_POST['periode'])) {
                    $return[$i]['periode'] = $_POST['periode'][$i];
                }

                if ($_POST['is_parent'][$_POST['id'][$i]])
                    $return[0]['message'] = "<br />" . $msg[0][3];
            }
            $return[0]['multiple'] = "YES";
            $return[0]['emptydata'] = "NO";
        } elseif (trim($_GET['id']) != "") {

            $return[0]['id'] = Dispatcher::Instance()->Decrypt((string )$_GET['id']);
            $return[0]['tglId'] = Dispatcher::Instance()->Decrypt((string )$_GET['tglId']);
            $return[0]['dataname'] = Dispatcher::Instance()->Decrypt($_GET['dataName']);
            $return[0]['message'] = Dispatcher::Instance()->Decrypt($_GET['message']);

            $return[0]['multiple'] = "NO";
            $return[0]['emptydata'] = "NO";

            $deleteUrl = Dispatcher::Instance()->Decrypt((string )$_GET['urlDelete']);
            $urlDel = explode('-', $deleteUrl); //-> Array ( [0] => unitkerja|deleteUnitkerja|do|html [1] => cari [2] => )
            $newUrl = explode('|', $urlDel['0']); //-> Array ( [0] => unitkerja [1] => deleteUnitkerja [2] => do [3] => html )
            $par = explode('|', isset($urlDel['1'])?$urlDel['1']:''); //->Array ( [0] => cari )
            $val = explode('|', isset($urlDel['2'])?$urlDel['2']:''); //->Array ( [0] => )
            $str = '';
            for ($i = 0; $i < count($par); $i++) {
                $str .= '&' . $par[$i] . '=' . Dispatcher::Instance()->Encrypt($val[$i]);
            }
            $return[0]['urlDelete'] = Dispatcher::Instance()->GetUrl($newUrl['0'], $newUrl['1'], $newUrl['2'], $newUrl['3']) . $str;

            $returnUrl = Dispatcher::Instance()->Decrypt((string )$_GET['urlReturn']);
            $urlRet = explode('-', $returnUrl);
            $newUrl = explode('|', $urlRet['0']);
            $par = explode('|', isset($urlRet['1'])?$urlRet['1']:'');
            $val = explode('|', isset($urlRet['2'])?$urlRet['2']:'');
            $str = '';
            for ($i = 0; $i < count($par); $i++) {
                $str .= '&' . $par[$i] . '=' . Dispatcher::Instance()->Encrypt($val[$i]);
            }
            //$aa = Dispatcher::Instance()->Encrypt($val[0]);
            $return[0]['urlReturn'] = Dispatcher::Instance()->GetUrl($newUrl['0'], $newUrl['1'], $newUrl['2'], $newUrl['3']) . $str;
            //$return[0]['urlDel'] = $aa;
            $return[0]['label'] = Dispatcher::Instance()->Decrypt((string )$_GET['label']);

        } else {
            $msg = Messenger::Instance()->Receive(__file__);
            $return[0]['label'] = $msg[0][0];
            $return[0]['urlDelete'] = $msg[0][1];
            $return[0]['urlReturn'] = $msg[0][2];
            //$this->RedirectTo($return[0]['urlReturn']);
            $return[0]['emptydata'] = "YES";
        }        
        		
		$nav[0]['url'] = $return[0]['urlReturn'];
        $nav[0]['menu'] = $return[0]['label'];
        $title = "Konfirmasi";
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);
        return $return;
    }

    function ParseTemplate($data = null)
    {
        #print_r($data);
        $this->mrTemplate->AddVar('content', 'LABEL', $data[0]['label']);
        $this->mrTemplate->AddVar('emptydata', 'MESSAGE', $data[0]['message']);
        $this->mrTemplate->AddVar('emptydata', 'LABEL', $data[0]['label']);
        $this->mrTemplate->AddVar('emptydata', 'FORM_ACTION_URL', $data[0]['urlDelete']);
        //$this->mrTemplate->AddVar('emptydata', 'URL', $data[0]['urlDel']);
        $this->mrTemplate->AddVar('emptydata', 'URL_KEMBALI', $data[0]['urlReturn']);
        if ($data[0]['emptydata'] == "NO") {
            $this->mrTemplate->AddVar('emptydata', 'IS_EMPTY_DATA', 'NO');
            if ($data[0]['multiple'] == "YES") {
                $this->mrTemplate->AddVar('multiple_delete', 'IS_MULTIPLE_DELETE', 'YES');
                for ($i = 0; $i < sizeof($data); $i++) {
                    $this->mrTemplate->AddVars('multiple_delete_item', $data[$i], 'MULTI_');
                    $this->mrTemplate->parseTemplate('multiple_delete_item', 'a');
                }
            } else {
                $this->mrTemplate->AddVar('multiple_delete', 'IS_MULTIPLE_DELETE', 'NO');
                $this->mrTemplate->AddVar('multiple_delete', "ID", $data[0]['id']);
                $this->mrTemplate->AddVar('multiple_delete', "TGL", $data[0]['tglId']);
                $this->mrTemplate->AddVar('multiple_delete', 'DATANAME', $data[0]['dataname']);
            }
        } else {
            $this->mrTemplate->AddVar('emptydata', 'IS_EMPTY_DATA', 'YES');
        }
    }

}

?>
