<?php
/**
 * @author Prima Noor 
 */

class DoDeleteSetting extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessSetting', 'core.setting');
        
        $id = Dispatcher::Instance()->Decrypt ($_GET['id']->Raw());                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.setting', 'setting', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>