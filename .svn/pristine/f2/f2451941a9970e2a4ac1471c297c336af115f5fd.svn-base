<?php

/**
 * @author Prima Noor 
 */

class DoAddCoreUserall extends JsonResponse 
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessCoreUserall', 'core.userall');

        $result = $proses->input();

        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.userall', 'CoreUserall', 'view', 'html') . '&display' . '&ascomponent=1")');
        } else {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.userall', 'addCoreUserall', 'view', 'html') . '&ascomponent=1")');
        }
    }
}

?>