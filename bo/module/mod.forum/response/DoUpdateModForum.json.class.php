<?php
/**
 * @author Prima Noor 
 */

class DoUpdateModForum extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModForum', 'mod.forum');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.forum', 'ModForum', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupModForum);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('mod.forum', 'updateModForum', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>