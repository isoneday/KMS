<?php
/**
 * @author Prima Noor 
 */

class DoDeleteSliderBanner extends JsonResponse
{
    function ProcessRequest()
    {
        $proses = GtfwDispt()->load->process('ProcessSliderBanner', 'cms.slider.banner');
        
        $id = $_GET['id']->Integer()->Raw();                
        
        $proses->delete($id);

        return array('exec' => 'replaceContentWithUrl("subcontent-element","' . GtfwDispt()->GetUrl('cms.slider.banner', 'SliderBanner', 'view', 'html') .'&display' . '&ascomponent=1")');
    }
}

?>