<?php
/**
 * @author Prima Noor 
 */

class DoUpdateEmailTemplate extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessEmailTemplate', 'comp.email.template');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('comp.email.template', 'EmailTemplate', 'view', 'html').'&display' . '&ascomponent=1")');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('comp.email.template', 'updateEmailTemplate', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>