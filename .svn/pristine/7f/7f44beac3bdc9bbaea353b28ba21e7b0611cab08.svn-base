<?php
/**
 * @author Prima Noor 
 */

class DoDeleteLegalInformation extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessLegalInformation', 'cms.legal.information');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('cms.legal.information', 'LegalInformation', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>