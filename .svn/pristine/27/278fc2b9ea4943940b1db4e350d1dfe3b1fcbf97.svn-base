<?php
/**
 * @author Prima Noor 
 */

class DoDeleteLanguage extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessLanguage', 'core.language');
        
        $id = $_GET['id']->SqlString()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.language', 'language', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>