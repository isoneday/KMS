<?php

/**
 * @author Prima Noor 
 */
class DoUpdateCoreGroupall extends JsonResponse {

    function ProcessRequest() {
        $proses = GtfwDispt()->load->process('ProcessCoreGroupall', 'core.groupall');
        $id = $_POST['id']->Integer()->Raw();

        $result = $proses->input();

        if ($result) {
            $url = Dispatcher::Instance()->GetUrl('core.groupall', 'CoreGroupall', 'view', 'html') . '&display';
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . $url . '&ascomponent=1");$("#top_menu").load("' . GtfwDispt()->GetUrl('comp.menu', 'moduleMenu', 'view', 'html') . '&ascomponent=1");$("#side_menu").load("' . GtfwDispt()->GetUrl('comp.menu', 'sideMenu', 'view', 'html') . '&ascomponent=1", function(resp, status, xhr){ if (status && $("#slick-toggle").hasClass("slick-icon")) { hideMenu(); };});');
        } else {
            $url = Dispatcher::Instance()->GetUrl('core.groupall', 'updateCoreGroupall', 'view', 'html') . '&id=' . $post['id'];
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . $url . '&ascomponent=1")');
        }
    }

}

?>