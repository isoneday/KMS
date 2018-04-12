<?php
/**
 * @author Prima Noor 
 */

class DoUpdateSetting extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessSetting', 'core.setting');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.setting', 'Setting', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupSetting);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('core.setting', 'updateSetting', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>