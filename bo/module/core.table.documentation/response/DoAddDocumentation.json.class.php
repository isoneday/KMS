<?php

/**
 * @author Prima Noor 
 */

class DoAddDocumentation extends JsonResponse 
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessDocumentation', 'core.table.documentation');

        $result = $proses->input();

        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.table.documentation', 'Documentation', 'view', 'html') . '&display' . '&ascomponent=1")');
        } else {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.table.documentation', 'addDocumentation', 'view', 'html') . '&ascomponent=1")');
        }
    }
}

?>