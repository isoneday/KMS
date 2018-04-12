<?php
/**
 * @author Prima Noor 
 */

class DoAddGroup extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessGroup');
        
        $result = $proses->input();
        
        if ($result) {
            $url = Dispatcher::Instance()->GetUrl('core.group', 'group', 'view', 'html').'&display';
        } else {
            $url = Dispatcher::Instance()->GetUrl('core.group', 'addGroup', 'view', 'html');
        }
        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . $url . '&ascomponent=1")');
    }
}

?>