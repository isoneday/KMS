<?php
/**
 * @author Prima Noor 
 */

class DoUpdateCoreMastertypedokumentasi extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessCoreMastertypedokumentasi', 'mod.core.mastertypedokumentasi');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.core.mastertypedokumentasi', 'CoreMastertypedokumentasi', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupCoreMastertypedokumentasi);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('mod.core.mastertypedokumentasi', 'updateCoreMastertypedokumentasi', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>