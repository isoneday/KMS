<?php
/**
 * @author Prima Noor 
 */

class DoUpload extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessUpload');
        
        $proses->input();
        
        $urlRedirect = GtfwDispt()->GetUrl('testing', 'upload', 'view', 'html');

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . $urlRedirect.'&display' . '&ascomponent=1")');
    }
}

?>