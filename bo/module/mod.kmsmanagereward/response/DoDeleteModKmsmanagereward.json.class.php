<?php
/**
 * @author Prima Noor 
 */

class DoDeleteModKmsmanagereward extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKmsmanagereward', 'mod.kmsmanagereward');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kmsmanagereward', 'ModKmsmanagereward', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>