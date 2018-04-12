<?php
/**
 * @author Prima Noor 
 */

class DoUpdateTermCondition extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessTermCondition', 'cms.term.condition');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('cms.term.condition', 'DetailTermCondition', 'view', 'html').'&display' . '&ascomponent=1"); ');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('cms.term.condition', 'updateTermCondition', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>