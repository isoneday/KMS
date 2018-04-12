<?php
/**
 * @author Prima Noor 
 */

class DoUpdateModKattrai extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKattrai', 'mod.kattrai');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kattrai', 'ModKattrai', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupModKattrai);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('mod.kattrai', 'updateModKattrai', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>