<?php
/**
 * @author Prima Noor 
 */

class DoAddTermCondition extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessTermCondition', 'cms.term.condition');
        
        $post = $_POST->AsArray();
        
        $result = $proses->input();
        
        $elmId = $_GET['elmId']->SqlString()->Raw();
        if ($result) {
            if (!empty($elmId)) {
                $url = GtfwDispt()->GetUrl('cms.term.condition', 'comboTermCondition', 'view', 'html').'&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('div_$elmId', '".$url."');");
            } else {
                $url = GtfwDispt()->GetUrl('cms.term.condition', 'TermCondition', 'view', 'html').'&display&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('subcontent-element', '".$url."');");
            }
        } else {
            if (!empty($elmId)) {
                return array('exec' => "replaceContentWithUrl('subcontent-element', '" . GtfwDispt()->GetUrl('cms.term.condition', (empty($post['dataId']) ? 'addTermCondition' : 'updateTermCondition'), 'view', 'html') . (!empty($elmId) ? ('&elmId=' . $elmId) : '') . "&ascomponent=1')");
            } else {
                return array('exec' => "replaceContentWithUrl('subcontent-element', '" . GtfwDispt()->GetUrl('cms.term.condition', (empty($post['dataId']) ? 'addTermCondition' : 'updateTermCondition'), 'view', 'html') . (!empty($elmId) ? ('&elmId=' . $elmId) : '') . "&ascomponent=1')");
            }
        }       
    }
}

?>