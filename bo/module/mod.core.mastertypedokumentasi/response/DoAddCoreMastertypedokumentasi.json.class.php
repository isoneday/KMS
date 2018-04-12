<?php
/**
 * @author Prima Noor 
 */

class DoAddCoreMastertypedokumentasi extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessCoreMastertypedokumentasi', 'mod.core.mastertypedokumentasi');
        
        $post = $_POST->AsArray();
        
        $result = $proses->input();
        
        $elmId = $_GET['elmId']->SqlString()->Raw();
        if ($result) {
            if (!empty($elmId)) {
                $url = GtfwDispt()->GetUrl('mod.core.mastertypedokumentasi', 'comboCoreMastertypedokumentasi', 'view', 'html').'&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('div_$elmId', '".$url."');closeGtPopup(popup$elmId);");
            } else {
                $url = GtfwDispt()->GetUrl('mod.core.mastertypedokumentasi', 'CoreMastertypedokumentasi', 'view', 'html').'&display&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('subcontent-element', '".$url."');closeGtPopup(popupCoreMastertypedokumentasi);");
            }
        } else {
            if (!empty($elmId)) {
                return array('exec' => "replaceContentWithUrl('popup-$elmId', '" . GtfwDispt()->GetUrl('mod.core.mastertypedokumentasi', (empty($post['dataId']) ? 'addCoreMastertypedokumentasi' : 'updateCoreMastertypedokumentasi'), 'view', 'html') . (!empty($elmId) ? ('&elmId=' . $elmId) : '') . "&ascomponent=1')");
            } else {
                return array('exec' => "replaceContentWithUrl('popup-subcontent', '" . GtfwDispt()->GetUrl('mod.core.mastertypedokumentasi', (empty($post['dataId']) ? 'addCoreMastertypedokumentasi' : 'updateCoreMastertypedokumentasi'), 'view', 'html') . (!empty($elmId) ? ('&elmId=' . $elmId) : '') . "&ascomponent=1')");
            }
        }       
    }
}

?>