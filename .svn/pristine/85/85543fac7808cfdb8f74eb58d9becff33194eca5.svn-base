<?php

/**
 * @author Prima Noor 
 */

class DoAddCoreGroupall extends JsonResponse 
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessCoreGroupall', 'core.groupall');

        $result = $proses->input();

        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.groupall', 'CoreGroupall', 'view', 'html') . '&display' . '&ascomponent=1")');
        } else {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.groupall', 'addCoreGroupall', 'view', 'html') . '&ascomponent=1")');
        }
    }
}

?>