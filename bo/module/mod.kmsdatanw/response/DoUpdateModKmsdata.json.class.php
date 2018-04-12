<?php
/** 
* @copyright Copyright (c) 2014, PT Gamatechno Indonesia
* @license http://gtfw.gamatechno.com/#license
*/

class DoUpdateModKmsdata extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessModKmsdata', 'mod.kmsdata');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('mod.kmsdata', 'ModKmsdata', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupModKmsdata);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('mod.kmsdata', 'updateModKmsdata', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>