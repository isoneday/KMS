<?php
/**
 * @author Prima Noor 
 */

class DoUpdateKey extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessKey');
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.lang.key', 'key', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupLangKey);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('core.lang.key', 'updateKey', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        } 
    }
}

?>