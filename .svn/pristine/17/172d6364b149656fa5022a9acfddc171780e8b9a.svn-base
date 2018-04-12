<?php
/**
 * @author Prima Noor 
 */

class DoDeleteCoreUserall extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessCoreUserall', 'core.userall');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.userall', 'CoreUserall', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>