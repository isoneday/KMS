<?php
/**
 * @author Prima Noor 
 */

class DoUpdateLegalInformation extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessLegalInformation', 'cms.legal.information');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('cms.legal.information', 'DetailLegalInformation', 'view', 'html').'&display' . '&ascomponent=1");');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('cms.legal.information', 'updateLegalInformation', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>