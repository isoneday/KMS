<?php
/**
 * @author Prima Noor 
 */

class DoUpdateModKmsmanagereward extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKmsmanagereward', 'mod.kmsmanagereward');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kmsmanagereward', 'ModKmsmanagereward', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupModKmsmanagereward);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('mod.kmsmanagereward', 'updateModKmsmanagereward', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>