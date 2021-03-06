<?php

/**
 * @author Prima Noor 
 */

class DoAddCoreCompany extends JsonResponse 
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessCoreCompany', 'core.company');

        $result = $proses->input();

        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.company', 'CoreCompany', 'view', 'html') . '&display' . '&ascomponent=1")');
        } else {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.company', 'addCoreCompany', 'view', 'html') . '&ascomponent=1")');
        }
    }
}

?>