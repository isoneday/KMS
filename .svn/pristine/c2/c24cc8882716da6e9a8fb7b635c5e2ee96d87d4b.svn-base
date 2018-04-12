<?php
/**
 * @author Prima Noor 
 */

class DoDeleteKey extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessKey');
        
        $id = $_GET['id']->SqlString()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' .GtfwDispt()->GetUrl('core.lang.key', 'key', 'view', 'html').'&display' . '&ascomponent=1")');
    }
}

?>