<?php
/**
 * @author Prima Noor 
 */

class DoAddCompanyProfile extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessCompanyProfile', 'cms.company.profile');
        
        $post = $_POST->AsArray();
        
        $result = $proses->input();
        
        $elmId = $_GET['elmId']->SqlString()->Raw();
        if ($result) {
            if (!empty($elmId)) {
                $url = GtfwDispt()->GetUrl('cms.company.profile', 'comboCompanyProfile', 'view', 'html').'&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('div_$elmId', '".$url."');");
            } else {
                $url = GtfwDispt()->GetUrl('cms.company.profile', 'CompanyProfile', 'view', 'html').'&display&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('subcontent-element', '".$url."');");
            }
        } else {
            if (!empty($elmId)) {
                return array('exec' => "replaceContentWithUrl('subcontent-element', '" . GtfwDispt()->GetUrl('cms.company.profile', (empty($post['dataId']) ? 'addCompanyProfile' : 'updateCompanyProfile'), 'view', 'html') . (!empty($elmId) ? ('&elmId=' . $elmId) : '') . "&ascomponent=1')");
            } else {
                return array('exec' => "replaceContentWithUrl('subcontent-element', '" . GtfwDispt()->GetUrl('cms.company.profile', (empty($post['dataId']) ? 'addCompanyProfile' : 'updateCompanyProfile'), 'view', 'html') . (!empty($elmId) ? ('&elmId=' . $elmId) : '') . "&ascomponent=1')");
            }
        }       
    }
}

?>