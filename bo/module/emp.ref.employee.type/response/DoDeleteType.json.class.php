<?php
/**
 * @author Prima Noor 
 */

class DoDeleteType extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessType', 'emp.ref.employee.type');
        
        $id = Dispatcher::Instance()->Decrypt($_GET['id']->Raw());                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('emp.ref.employee.type', 'type', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>