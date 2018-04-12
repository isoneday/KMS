<?php

/**
 * @author Prima Noor 
 */

class DoAddUser extends JsonResponse 
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessUser', 'core.user');

        $result = $proses->input();

        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.user', 'User', 'view', 'html') . '&display' . '&ascomponent=1")');
        } else {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.user', 'addUser', 'view', 'html') . '&ascomponent=1")');
        }
    }
}

?>