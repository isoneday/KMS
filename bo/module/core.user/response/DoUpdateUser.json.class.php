<?php
/**
 * @author Prima Noor 
 */

class DoUpdateUser extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessUser', 'core.user');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.user', 'User', 'view', 'html').'&display' . '&ascomponent=1")');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.user', 'updateUser', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>