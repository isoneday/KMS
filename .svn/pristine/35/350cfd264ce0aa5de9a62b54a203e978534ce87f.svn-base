<?php

/**
 * @author Prima Noor 
 */

class DoAddLanguage extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessLanguage', 'core.language');

        $post = $_POST->AsArray();

        $result = $proses->input();

        if ($result) {
            $url = GtfwDispt()->GetUrl('core.language', 'language', 'view', 'html') . '&ascomponent=1';
            return array('exec' => "replaceContentWithUrl('subcontent-element', '" . $url . "');closeGtPopup(popupLanguage);");
        } else {
            return array('exec' => "replaceContentWithUrl('popup-subcontent', '" . GtfwDispt()->GetUrl('core.language', (empty($post['dataId']) ? 'addLanguage' : 'updateLanguage'), 'view', 'html') . "&ascomponent=1')");
        }
    }
}

?>