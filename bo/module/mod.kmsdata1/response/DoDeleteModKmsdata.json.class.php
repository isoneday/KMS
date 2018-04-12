<?php
/**
 * @author Prima Noor 
 */

class DoDeleteModKmsdata extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKmsdata', 'mod.kmsdata');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kmsdata', 'ModKmsdata', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>