<?php
/**
 * @author Prima Noor 
 */

class DoUpdateCoreCompany extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessCoreCompany', 'core.company');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.company', 'CoreCompany', 'view', 'html').'&display' . '&ascomponent=1")');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.company', 'updateCoreCompany', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>