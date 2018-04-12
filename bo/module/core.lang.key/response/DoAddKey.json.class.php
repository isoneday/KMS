<?php
/**
 * @author Prima Noor 
 */

class DoAddKey extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessKey');

        $post = $_POST->AsArray();

        $result = $proses->input();

        if ($result) {
            $url = GtfwDispt()->GetUrl('core.lang.key', 'key', 'view', 'html') . '&display&ascomponent=1';
            return array('exec' => "replaceContentWithUrl('subcontent-element', '" . $url . "');closeGtPopup(popupLangKey);");
        } else {
            return array('exec' => "replaceContentWithUrl('popup-subcontent', '" . GtfwDispt()->GetUrl('core.lang.key', (empty($post['dataId']) ? 'addKey' : 'updateKey'), 'view', 'html') . "&ascomponent=1')");
        }
    }
}

?>