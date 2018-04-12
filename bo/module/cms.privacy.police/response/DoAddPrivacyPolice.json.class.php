<?php
/**
 * @author Prima Noor 
 */

class DoAddPrivacyPolice extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessPrivacyPolice', 'cms.privacy.police');
        
        $post = $_POST->AsArray();
        
        $result = $proses->input();
        
        $elmId = $_GET['elmId']->SqlString()->Raw();
        if ($result) {
            if (!empty($elmId)) {
                $url = GtfwDispt()->GetUrl('cms.privacy.police', 'comboPrivacyPolice', 'view', 'html').'&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('div_$elmId', '".$url."');");
            } else {
                $url = GtfwDispt()->GetUrl('cms.privacy.police', 'PrivacyPolice', 'view', 'html').'&display&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('subcontent-element', '".$url."');");
            }
        } else {
            if (!empty($elmId)) {
                return array('exec' => "replaceContentWithUrl('subcontent-element', '" . GtfwDispt()->GetUrl('cms.privacy.police', (empty($post['dataId']) ? 'addPrivacyPolice' : 'updatePrivacyPolice'), 'view', 'html') . (!empty($elmId) ? ('&elmId=' . $elmId) : '') . "&ascomponent=1')");
            } else {
                return array('exec' => "replaceContentWithUrl('subcontent-element', '" . GtfwDispt()->GetUrl('cms.privacy.police', (empty($post['dataId']) ? 'addPrivacyPolice' : 'updatePrivacyPolice'), 'view', 'html') . (!empty($elmId) ? ('&elmId=' . $elmId) : '') . "&ascomponent=1')");
            }
        }       
    }
}

?>