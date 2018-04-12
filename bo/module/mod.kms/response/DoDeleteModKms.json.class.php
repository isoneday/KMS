<?php
/**
 * @author Prima Noor 
 */

class DoDeleteModKms extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKms', 'mod.kms');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kms', 'ModKms', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>