<?php

/**
 * @author Prima Noor 
 */

class DoAddNotificationTemplate extends JsonResponse 
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessNotificationTemplate', 'comp.notification.template');

        $result = $proses->input();

        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('comp.notification.template', 'NotificationTemplate', 'view', 'html') . '&display' . '&ascomponent=1")');
        } else {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('comp.notification.template', 'addNotificationTemplate', 'view', 'html') . '&ascomponent=1")');
        }
    }
}

?>