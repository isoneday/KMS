<?php
/**
 * @author Prima Noor 
 */

class DoDeleteGroup extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessGroup');
        
        $id = $_GET['id']->Integer()->Raw();  
        $result = $proses->delete($id);
        
        $url = GtfwDispt()->GetUrl('core.group', 'group', 'view', 'html');

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . $url.'&display' . '&ascomponent=1")');
    }
}

?>