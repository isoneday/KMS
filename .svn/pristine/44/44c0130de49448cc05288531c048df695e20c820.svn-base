<?php
/**
 * @author Prima Noor 
 */

class DoDeleteCompanyProfile extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessCompanyProfile', 'cms.company.profile');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('cms.company.profile', 'CompanyProfile', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>