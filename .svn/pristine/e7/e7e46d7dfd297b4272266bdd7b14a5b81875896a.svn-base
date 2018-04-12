<?php
/**
 * @author Prima Noor 
 */

class DoApplicationPackager extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessPackager');
        
        $result = $proses->packageApplication();
        
        $urlRedirect = Dispatcher::Instance()->GetUrl('core.packager', 'applicationPackager', 'view', 'html');

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . $urlRedirect. '&ascomponent=1")');
    }
}

?>