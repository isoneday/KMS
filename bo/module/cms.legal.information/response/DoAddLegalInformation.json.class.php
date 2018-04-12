<?php
/**
 * @author Prima Noor 
 */

class DoAddLegalInformation extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessLegalInformation', 'cms.legal.information');
        
        $post = $_POST->AsArray();
        
        $result = $proses->input();
        
        $elmId = $_GET['elmId']->SqlString()->Raw();
        if ($result) {
            if (!empty($elmId)) {
                $url = GtfwDispt()->GetUrl('cms.legal.information', 'comboLegalInformation', 'view', 'html').'&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('div_$elmId', '".$url."');");
            } else {
                $url = GtfwDispt()->GetUrl('cms.legal.information', 'LegalInformation', 'view', 'html').'&display&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('subcontent-element', '".$url."');");
            }
        } else {
            if (!empty($elmId)) {
                return array('exec' => "replaceContentWithUrl('popup-$elmId', '" . GtfwDispt()->GetUrl('cms.legal.information', (empty($post['dataId']) ? 'addLegalInformation' : 'updateLegalInformation'), 'view', 'html') . (!empty($elmId) ? ('&elmId=' . $elmId) : '') . "&ascomponent=1')");
            } else {
                return array('exec' => "replaceContentWithUrl('subcontent-element', '" . GtfwDispt()->GetUrl('cms.legal.information', (empty($post['dataId']) ? 'addLegalInformation' : 'updateLegalInformation'), 'view', 'html') . (!empty($elmId) ? ('&elmId=' . $elmId) : '') . "&ascomponent=1')");
            }
        }       
    }
}

?>