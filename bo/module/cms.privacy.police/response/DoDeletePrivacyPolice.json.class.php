<?php
/**
 * @author Prima Noor 
 */

class DoDeletePrivacyPolice extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessPrivacyPolice', 'cms.privacy.police');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('cms.privacy.police', 'PrivacyPolice', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>