<?php
/**
 * @author Prima Noor 
 */

class DoAddModKmsmanagereward extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKmsmanagereward', 'mod.kmsmanagereward');
        
        $post = $_POST->AsArray();
        
        $result = $proses->input();
        
        $elmId = $_GET['elmId']->SqlString()->Raw();
        if ($result) {
            if (!empty($elmId)) {
                $url = GtfwDispt()->GetUrl('mod.kmsmanagereward', 'comboModKmsmanagereward', 'view', 'html').'&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('div_$elmId', '".$url."');closeGtPopup(popup$elmId);");
            } else {
                $url = GtfwDispt()->GetUrl('mod.kmsmanagereward', 'ModKmsmanagereward', 'view', 'html').'&display&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('subcontent-element', '".$url."');closeGtPopup(popupModKmsmanagereward);");
            }
        } else {
            if (!empty($elmId)) {
                return array('exec' => "replaceContentWithUrl('popup-$elmId', '" . GtfwDispt()->GetUrl('mod.kmsmanagereward', (empty($post['dataId']) ? 'addModKmsmanagereward' : 'updateModKmsmanagereward'), 'view', 'html') . (!empty($elmId) ? ('&elmId=' . $elmId) : '') . "&ascomponent=1')");
            } else {
                return array('exec' => "replaceContentWithUrl('popup-subcontent', '" . GtfwDispt()->GetUrl('mod.kmsmanagereward', (empty($post['dataId']) ? 'addModKmsmanagereward' : 'updateModKmsmanagereward'), 'view', 'html') . (!empty($elmId) ? ('&elmId=' . $elmId) : '') . "&ascomponent=1')");
            }
        }       
    }
}

?>