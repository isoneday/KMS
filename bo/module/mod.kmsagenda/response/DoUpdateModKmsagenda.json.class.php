<?php
/**
 * @author Prima Noor 
 */

class DoUpdateModKmsagenda extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKmsagenda', 'mod.kmsagenda');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kmsagenda', 'ModKmsagenda', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupModKmsagenda);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('mod.kmsagenda', 'updateModKmsagenda', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>