<?php

/**
 * @author Prima Noor 
 */

class DoAddEmailTemplate extends JsonResponse 
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessEmailTemplate', 'comp.email.template');

        $result = $proses->input();

        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('comp.email.template', 'EmailTemplate', 'view', 'html') . '&display' . '&ascomponent=1")');
        } else {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('comp.email.template', 'addEmailTemplate', 'view', 'html') . '&ascomponent=1")');
        }
    }
}

?>