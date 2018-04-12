<?php
/**
 * @author Prima Noor 
 */

class DoUpdateCmsNews extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessCmsNews', 'cms.news');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('cms.news', 'CmsNews', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupCmsNews);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('cms.news', 'updateCmsNews', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>