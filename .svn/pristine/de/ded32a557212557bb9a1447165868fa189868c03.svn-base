<?php
/**
 * @author Prima Noor 
 */

class DoUpdateNotificationTemplate extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessNotificationTemplate', 'comp.notification.template');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('comp.notification.template', 'NotificationTemplate', 'view', 'html').'&display' . '&ascomponent=1")');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('comp.notification.template', 'updateNotificationTemplate', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>