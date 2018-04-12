<?php
/**
 * @author Prima Noor 
 */

class DoDeleteCoreMastertypedokumentasi extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessCoreMastertypedokumentasi', 'mod.core.mastertypedokumentasi');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.core.mastertypedokumentasi', 'CoreMastertypedokumentasi', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>