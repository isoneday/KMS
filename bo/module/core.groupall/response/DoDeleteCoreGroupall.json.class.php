<?php
/**
 * @author Prima Noor 
 */

class DoDeleteCoreGroupall extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessCoreGroupall', 'core.groupall');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.groupall', 'CoreGroupall', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>