<?php
/**
 * @author Prima Noor 
 */

class DoUpdateSmsTemplate extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessSmsTemplate', 'comp.sms.template');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('comp.sms.template', 'SmsTemplate', 'view', 'html').'&display' . '&ascomponent=1")');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('comp.sms.template', 'updateSmsTemplate', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>