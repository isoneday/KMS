<?php
/**
 * @author Prima Noor 
 */

class DoUpdateEmployeeMini extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessEmployeeMini', 'emp.employee.mini');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('emp.employee.mini', 'EmployeeMini', 'view', 'html').'&display' . '&ascomponent=1")');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('emp.employee.mini', 'updateEmployeeMini', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>