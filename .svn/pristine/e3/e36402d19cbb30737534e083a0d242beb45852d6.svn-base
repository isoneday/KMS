<?php

/**
 * @author Prima Noor 
 */

class DoUpdateMenu extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('Process');

        $result = $proses->input();

        if ($result) {
            $url = GtfwDispt()->GetUrl('core.menu', 'menuList', 'view', 'html') . '&ascomponent=1&display';
            return array('exec' => "replaceContentWithUrl('subcontent-element', '" . $url . "');closeGtPopup(gtpopup);");
        } else {
            return array('exec' => "replaceContentWithUrl('popup-subcontent', '" . GtfwDispt()->GetUrl('core.menu', (empty($post['dataId']) ? 'addMenu' : 'updateMenu'), 'view', 'html'). (!empty($post['dataId'])?('&dataId='.$post['dataId']):'') . "&ascomponent=1')");
        }
    }
}

?>