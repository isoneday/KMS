<?php
/**
 * @author Prima Noor 
 */

class DoDeleteModKmsmeeting extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKmsmeeting', 'mod.kmsmeeting');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kmsmeeting', 'ModKmsmeeting', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>