<?php
/**
 * @author Prima Noor 
 */

class DoDeleteNotificationTemplate extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessNotificationTemplate', 'comp.notification.template');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('comp.notification.template', 'NotificationTemplate', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>