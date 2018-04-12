<?php
/**
 * @author Prima Noor 
 */

class DoUpdateLanguage extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessLanguage', 'core.language');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.language', 'Language', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupLanguage);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('core.language', 'updateLanguage', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }         
    }
}

?>