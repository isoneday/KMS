<?php
/**
 * @author Prima Noor 
 */

class DoDeleteDocumentation extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessDocumentation', 'core.table.documentation');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.table.documentation', 'documentation', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>