<?php
/**
 * @author Prima Noor 
 */

class DoDeleteSmsTemplate extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessSmsTemplate', 'comp.sms.template');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('comp.sms.template', 'SmsTemplate', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>