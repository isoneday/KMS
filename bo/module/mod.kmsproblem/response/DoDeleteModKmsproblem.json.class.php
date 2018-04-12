<?php
/**
 * @author Prima Noor 
 */

class DoDeleteModKmsproblem extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKmsproblem', 'mod.kmsproblem');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kmsproblem', 'ModKmsproblem', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>