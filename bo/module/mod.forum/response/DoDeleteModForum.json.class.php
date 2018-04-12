<?php
/**
 * @author Prima Noor 
 */

class DoDeleteModForum extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModForum', 'mod.forum');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.forum', 'ModForum', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>