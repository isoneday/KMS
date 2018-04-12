<?php
/**
 * @author Prima Noor 
 */

class DoDeleteEmailTemplate extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessEmailTemplate', 'comp.email.template');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('comp.email.template', 'EmailTemplate', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>