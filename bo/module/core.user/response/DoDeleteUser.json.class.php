<?php
/**
 * @author Prima Noor 
 */

class DoDeleteUser extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessUser', 'core.user');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.user', 'user', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>