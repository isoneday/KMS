<?php
/**
 * @author Prima Noor 
 */

class DoUpdateModKmsmeeting extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKmsmeeting', 'mod.kmsmeeting');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kmsmeeting', 'ModKmsmeeting', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupModKmsmeeting);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('mod.kmsmeeting', 'updateModKmsmeeting', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>