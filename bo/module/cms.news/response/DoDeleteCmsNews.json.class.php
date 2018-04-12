<?php
/**
 * @author Prima Noor 
 */

class DoDeleteCmsNews extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessCmsNews', 'cms.news');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('cms.news', 'CmsNews', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>