<?php
/**
 * @author Prima Noor 
 */

class DoUpdatePrivacyPolice extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessPrivacyPolice', 'cms.privacy.police');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('cms.privacy.police', 'DetailPrivacyPolice', 'view', 'html').'&display' . '&ascomponent=1");');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('cms.privacy.police', 'updatePrivacyPolice', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>