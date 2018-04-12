<?php

/**
 * @author Prima Noor 
 */

class DoAddSmsTemplate extends JsonResponse 
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessSmsTemplate', 'comp.sms.template');

        $result = $proses->input();

        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('comp.sms.template', 'SmsTemplate', 'view', 'html') . '&display' . '&ascomponent=1")');
        } else {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('comp.sms.template', 'addSmsTemplate', 'view', 'html') . '&ascomponent=1")');
        }
    }
}

?>