<?php
/**
 * @author Prima Noor 
 */

class DoDeleteCmsFaq extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessCmsFaq', 'cms.faq');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('cms.faq', 'CmsFaq', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>