<?php
/**
 * @author Prima Noor 
 */

class DoDeleteStatus extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessStatus', 'emp.ref.employee.status');
        
        $id = Dispatcher::Instance()->Decrypt($_GET['id']->Raw());               
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('emp.ref.employee.status', 'status', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>