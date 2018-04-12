<?php
/**
 * @author Prima Noor 
 */

class DoUpdateGroup extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessGroup');
        
        $post = $_POST->AsArray();
        
        $result = $proses->input();
        
        if ($result) {
            $url = Dispatcher::Instance()->GetUrl('core.group', 'group', 'view', 'html').'&display';
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . $url . '&ascomponent=1");$("#top_menu").load("'.GtfwDispt()->GetUrl('comp.menu', 'moduleMenu', 'view', 'html').'&ascomponent=1");$("#side_menu").load("'.GtfwDispt()->GetUrl('comp.menu', 'sideMenu', 'view', 'html').'&ascomponent=1", function(resp, status, xhr){ if (status && $("#slick-toggle").hasClass("slick-icon")) { hideMenu(); };});');
        } else {
            $url = Dispatcher::Instance()->GetUrl('core.group', 'updateGroup', 'view', 'html').'&id='.$post['id'];
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . $url . '&ascomponent=1")');
        }
    }
}

?>