<?php
/**
 * @author Prima Noor 
 */

class DoDeleteMenu extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('Process', 'core.menu');
        
        $id = $_GET['dataId']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('core.menu', 'menuList', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>