<?php
/**
 * @author Prima Noor 
 */

class DoUpdateSliderBanner extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessSliderBanner', 'cms.slider.banner');
        $id = $_POST['id']->Integer()->Raw();
        
        $result = $proses->input();
        
        if ($result) {
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('cms.slider.banner', 'SliderBanner', 'view', 'html').'&display' . '&ascomponent=1");');  
        } else {  
            return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('cms.slider.banner', 'updateSliderBanner', 'view', 'html').'&id='. $id . '&ascomponent=1")');
        }        
    }
}

?>