<?php

/**
 * @author Prima Noor 
 */

class DoAddSetting extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessSetting', 'core.setting');

        $post = $_POST->AsArray();

        $result = $proses->input();
        if ($result) {
            $url = GtfwDispt()->GetUrl('core.setting', 'setting', 'view', 'html') . '&ascomponent=1';
            return array('exec' => "replaceContentWithUrl('subcontent-element', '" . $url . "');closeGtPopup(popupSetting);");
        } else {
            return array('exec' => "replaceContentWithUrl('popup-subcontent', '" . GtfwDispt()->GetUrl('core.setting', (empty($post['dataId']) ? 'addSetting' : 'updateSetting'), 'view', 'html') . "&ascomponent=1')");
        }
    }
}

?>