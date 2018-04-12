<?php
/**
 * @author Prima Noor 
 */

class DoUpdateStatus extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessStatus', 'emp.ref.employee.status');
        
		$id = NULL;
		if(!empty($_SESSION['emp.ref.employee.status']['data_id']))
			$id = Dispatcher::Instance()->Encrypt($_SESSION['emp.ref.employee.status']['data_id']);                  
                    
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('emp.ref.employee.status', 'Status', 'view', 'html').'&display' . '&ascomponent=1"); ;closeGtPopup(popupStatus);');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("popup-subcontent","' . GtfwDispt()->GetUrl('emp.ref.employee.status', 'updateStatus', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>