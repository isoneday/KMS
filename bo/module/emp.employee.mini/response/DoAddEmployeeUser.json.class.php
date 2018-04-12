<?php

/**
 * @author Prima Noor 
 */
class DoAddEmployeeUser extends JsonResponse {

    function ProcessRequest() {
        $proses = GtfwDispt()->load->process('ProcessEmployeeUser', 'emp.employee.mini');

        $result = $proses->input();

        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('emp.employee.mini', 'EmployeeMini', 'view', 'html') . '&display' . '&ascomponent=1")');
        } else {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('emp.employee.mini', 'addEmployeeUser', 'view', 'html') . '&ascomponent=1")');
        }
    }

}

?>