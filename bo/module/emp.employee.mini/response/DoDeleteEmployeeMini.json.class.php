<?php
/**
 * @author Prima Noor 
 */

class DoDeleteEmployeeMini extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessEmployeeMini', 'emp.employee.mini');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('emp.employee.mini', 'EmployeeMini', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>