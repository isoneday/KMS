<?php
/**
 * @author Prima Noor 
 */

class DoUpdateCompanyProfile extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessCompanyProfile', 'cms.company.profile');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('cms.company.profile', 'DetailCompanyProfile', 'view', 'html').'&display' . '&ascomponent=1");');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('cms.company.profile', 'updateCompanyProfile', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>