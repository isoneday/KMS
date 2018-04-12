<?php
/**
 * @author Prima Noor 
 */

class DoUpdateModKmstraining extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKmstraining', 'mod.kmstraining');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kmstraining', 'ModKmstraining', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupModKmstraining);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('mod.kmstraining', 'updateModKmstraining', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>