<?php

/**
 * @author Prima Noor 
 */
class DoResetEmployeePassword extends JsonResponse {

    function ProcessRequest() {
        $proses = GtfwDispt()->load->process('ProcessEmployeeUser', 'emp.employee.mini');

        $id = $_GET['id']->Integer()->Raw();

        $proses->resetPassword($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('emp.employee.mini', 'employeeMini', 'view', 'html') . '&display' . '&ascomponent=1")');
    }

}

?>