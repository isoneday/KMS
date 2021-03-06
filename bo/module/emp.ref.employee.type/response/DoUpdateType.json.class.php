<?php
/**
 * @author Prima Noor 
 */

class DoUpdateType extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessType', 'emp.ref.employee.type');
        
		$id = NULL;
		if(!empty($_SESSION['emp.ref.employee.type']['data_id']))
			$id = Dispatcher::Instance()->Encrypt($_SESSION['emp.ref.employee.type']['data_id']);                  
                    
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('emp.ref.employee.type', 'Type', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupType);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('emp.ref.employee.type', 'updateType', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>