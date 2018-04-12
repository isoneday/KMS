<?php
/**
 * @author Prima Noor 
 */

class DoAddMenu extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('Process');
        
        $post = $_POST->AsArray();
        
        $result = $proses->input();
        
        if ($result) {
            $elmId = $_GET['elmId']->SqlString()->Raw();
            if (!empty($elmId)) {
                $url = GtfwDispt()->GetUrl('core.menu', 'comboMenu', 'view', 'html').'&ascomponent=1&display';
                return array('exec' => "replaceContentWithUrl('div_$elmId', '".$url."');closeGtPopup(popup$elmId);");
            } else {
                $url = GtfwDispt()->GetUrl('core.menu', 'menuList', 'view', 'html').'&ascomponent=1&display';
                return array('exec' => "replaceContentWithUrl('subcontent-element', '".$url."');closeGtPopup(gtpopup);");
            }
        } else {
            return array('exec' => "replaceContentWithUrl('popup-subcontent', '".GtfwDispt()->GetUrl('core.menu', (empty($post['dataId'])?'addMenu':'updateMenu'), 'view', 'html')."&ascomponent=1')");    
        }        
    }
}

?>