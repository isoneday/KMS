<?php
/**
 * @author Prima Noor 
 */

class DoUpdateUnit extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessUnit', 'core.unit');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.unit', 'Unit', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupUnit);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('core.unit', 'updateUnit', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>