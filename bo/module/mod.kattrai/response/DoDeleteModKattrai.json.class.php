<?php
/**
 * @author Prima Noor 
 */

class DoDeleteModKattrai extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKattrai', 'mod.kattrai');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kattrai', 'ModKattrai', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>