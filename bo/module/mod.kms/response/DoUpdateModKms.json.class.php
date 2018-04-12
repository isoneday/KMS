<?php
/**
 * @author Prima Noor 
 */

class DoUpdateModKms extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKms', 'mod.kms');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kms', 'ModKms', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupModKms);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('mod.kms', 'updateModKms', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>