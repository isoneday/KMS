<?php
/**
 * @author Prima Noor 
 */

class DoDeleteModKmstraining extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKmstraining', 'mod.kmstraining');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kmstraining', 'ModKmstraining', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>