<?php
/**
 * @author Prima Noor 
 */

class DoAddModKmsdata extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKmsdata', 'mod.kmsdata');
        
        $post = $_POST->AsArray();
        
        $result = $proses->input();
        
        $elmId = $_GET['elmId']->SqlString()->Raw();
        if ($result) {
            if (!empty($elmId)) {
                $url = GtfwDispt()->GetUrl('mod.kmsdata', 'comboModKmsdata', 'view', 'html').'&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('div_$elmId', '".$url."');closeGtPopup(popup$elmId);");
            } else {
                $url = GtfwDispt()->GetUrl('mod.kmsdata', 'ModKmsdata', 'view', 'html').'&display&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('subcontent-element', '".$url."');closeGtPopup(popupModKmsdata);");
            }
        } else {
            if (!empty($elmId)) {
                return array('exec' => "replaceContentWithUrl('popup-$elmId', '" . GtfwDispt()->GetUrl('mod.kmsdata', (empty($post['dataId']) ? 'addModKmsdata' : 'updateModKmsdata'), 'view', 'html') . (!empty($elmId) ? ('&elmId=' . $elmId) : '') . "&ascomponent=1')");
            } else {
                return array('exec' => "replaceContentWithUrl('popup-subcontent', '" . GtfwDispt()->GetUrl('mod.kmsdata', (empty($post['dataId']) ? 'addModKmsdata' : 'updateModKmsdata'), 'view', 'html') . (!empty($elmId) ? ('&elmId=' . $elmId) : '') . "&ascomponent=1')");
            }
        }       
    }
}

?>