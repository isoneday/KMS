<?php
/**
 * @author Prima Noor 
 */

class DoUpdateCmsFaq extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessCmsFaq', 'cms.faq');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('cms.faq', 'CmsFaq', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupCmsFaq);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('cms.faq', 'updateCmsFaq', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>