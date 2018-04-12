<?php
/**
 * @author Prima Noor 
 */

class DoDeleteModKmsreward extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKmsreward', 'mod.kmsreward');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kmsreward', 'ModKmsreward', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>