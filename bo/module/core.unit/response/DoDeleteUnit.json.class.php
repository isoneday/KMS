<?php
/**
 * @author Prima Noor 
 */

class DoDeleteUnit extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessUnit', 'core.unit');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.unit', 'unit', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>