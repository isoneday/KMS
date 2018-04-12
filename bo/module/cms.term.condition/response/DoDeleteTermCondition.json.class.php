<?php
/**
 * @author Prima Noor 
 */

class DoDeleteTermCondition extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessTermCondition', 'cms.term.condition');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('cms.term.condition', 'TermCondition', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>