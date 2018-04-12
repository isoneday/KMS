<?php
/**
 * @author Prima Noor 
 */

class DoDeleteModKmsagenda extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKmsagenda', 'mod.kmsagenda');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kmsagenda', 'ModKmsagenda', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>