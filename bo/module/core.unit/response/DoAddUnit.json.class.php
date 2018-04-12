<?php
/**
 * @author Prima Noor 
 */

class DoAddUnit extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessUnit', 'core.unit');
        
        $post = $_POST->AsArray();
        
        $result = $proses->input();
        
        $elmId = $_GET['elmId']->SqlString()->Raw();
        if ($result) {
            if (!empty($elmId)) {
                $url = GtfwDispt()->GetUrl('core.unit', 'comboUnit', 'view', 'html').'&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('div_$elmId', '".$url."');closeGtPopup(popup$elmId);");
            } else {
                $url = GtfwDispt()->GetUrl('core.unit', 'unit', 'view', 'html').'&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('subcontent-element', '".$url."');closeGtPopup(popupUnit);");
            }
        } else {
            return array('exec' => "replaceContentWithUrl('popup-subcontent', '".GtfwDispt()->GetUrl('core.unit', (empty($post['dataId'])?'addUnit':'updateUnit'), 'view', 'html').(!empty($elmId)?('&elmId='.$elmId):'')."&ascomponent=1')");    
        }        
    }
}

?>