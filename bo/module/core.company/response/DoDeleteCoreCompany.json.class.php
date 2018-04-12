<?php

/**
 * @author Prima Noor 
 */
class DoDeleteCoreCompany extends JsonResponse {

    function ProcessRequest() {
        $proses = GtfwDispt()->load->process('ProcessCoreCompany', 'core.company');

        $id = Dispatcher::Instance()->Decrypt($_GET['id']->Raw());

        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.company', 'CoreCompany', 'view', 'html') . '&display' . '&ascomponent=1")');
    }

}

?>