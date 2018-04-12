<?php
/**
 * @author Prima Noor 
 */

class DoUpdateCoreUserall extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessCoreUserall', 'core.userall');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.userall', 'CoreUserall', 'view', 'html').'&display' . '&ascomponent=1")');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.userall', 'updateCoreUserall', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>