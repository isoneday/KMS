<?php
/**
 * @author Prima Noor 
 */

class DoUpdateModKmsproblem extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKmsproblem', 'mod.kmsproblem');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kmsproblem', 'ModKmsproblem', 'view', 'html').'&display' . '&ascomponent=1");closeGtPopup(popupModKmsproblem);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('mod.kmsproblem', 'updateModKmsproblem', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>