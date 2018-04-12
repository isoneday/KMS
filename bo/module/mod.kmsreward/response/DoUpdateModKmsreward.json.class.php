<?php
/**
 * @author Prima Noor 
 */

class DoUpdateModKmsreward extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKmsreward', 'mod.kmsreward');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kmsreward', 'ModKmsreward', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupModKmsreward);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('mod.kmsreward', 'updateModKmsreward', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>