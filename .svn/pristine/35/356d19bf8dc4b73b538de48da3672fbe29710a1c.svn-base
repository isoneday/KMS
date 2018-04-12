<?php
/**
 * @author Prima Noor 
 */

class DoAddSliderBanner extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessSliderBanner', 'cms.slider.banner');
        
        $post = $_POST->AsArray();
        
        $result = $proses->input();
        
        $elmId = $_GET['elmId']->SqlString()->Raw();
        if ($result) {
            if (!empty($elmId)) {
                $url = GtfwDispt()->GetUrl('cms.slider.banner', 'comboSliderBanner', 'view', 'html').'&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('div_$elmId', '".$url."');closeGtPopup(popup$elmId);");
            } else {
                $url = GtfwDispt()->GetUrl('cms.slider.banner', 'SliderBanner', 'view', 'html').'&display&ascomponent=1';
                return array('exec' => "replaceContentWithUrl('subcontent-element', '".$url."');");
            }
        } else {
            if (!empty($elmId)) {
                return array('exec' => "replaceContentWithUrl('popup-$elmId', '" . GtfwDispt()->GetUrl('cms.slider.banner', (empty($post['dataId']) ? 'addSliderBanner' : 'updateSliderBanner'), 'view', 'html') . (!empty($elmId) ? ('&elmId=' . $elmId) : '') . "&ascomponent=1')");
            } else {
                return array('exec' => "replaceContentWithUrl('subcontent-element', '" . GtfwDispt()->GetUrl('cms.slider.banner', (empty($post['dataId']) ? 'addSliderBanner' : 'updateSliderBanner'), 'view', 'html') . (!empty($elmId) ? ('&elmId=' . $elmId) : '') . "&ascomponent=1')");
            }
        }       
    }
}

?>