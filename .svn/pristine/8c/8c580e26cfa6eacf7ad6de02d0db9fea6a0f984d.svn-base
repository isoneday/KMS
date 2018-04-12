<?php

/**
 * @author Prima Noor 
 */
class ViewDetailSliderBanner extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_detail_sliderbanner.html');
    }

    function ProcessRequest() {
        $ObjSliderBanner = GtfwDispt()->load->business('SliderBanner', 'cms.slider.banner');

        $id = $_GET['id']->Integer()->Raw();

        $detail = $ObjSliderBanner->getDetailSliderBanner($id);


        return compact('detail');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);

        if (!empty($detail)) {
            $detail['status'] == '1' ? $detail['status'] = GtfwLangText('active') : $detail['status'] = GtfwLangText('not_active');

            $path = Configuration::Instance()->GetValue('application', 'cms_save_path') . $detail['photo'];
            if (($detail['photo_type'] == 'jpg') || ($detail['photo_type'] == 'PNG') || ($detail['photo_type'] == 'gif') || ($detail['photo_type'] == 'png')) {
                $detail['photo_file'] = "<b><a href=" . $path . " target=_blank> " . $detail['photo_origin'] . "</a></b>";
                $detail['photop'] = "<img src=" . $path . " width='100' height='100' alt='" . $detail['photo_origin'] . "' title='" . $detail['photo_origin'] . "'>";
                $this->mrTemplate->SetAttribute('photo_preview', 'visibility', 'visible');
                $this->mrTemplate->addVar('photo_preview', 'PHOTOP', $detail['photop']);
                #$this->mrTemplate->AddVars('preview', $detail, '');
            } else {
                $detail['photo_file'] = "<b><a href=" . $path . " target=_blank> " . $detail['photo_origin'] . "</a></b>";
                $detail['photop'] = '';
            }

            $this->mrTemplate->SetAttribute('current_photo', 'visibility', 'visible');
            $this->mrTemplate->addVar('current_photo', 'PHOTO_FILE', $detail['photo_file']);
            $this->mrTemplate->addVar('current_photo', 'PHOTO', $detail['photo']);
            $this->mrTemplate->addVar('current_photo', 'PHOTO_ORIGIN', $detail['photo_origin']);
            $this->mrTemplate->addVar('current_photo', 'PHOTO_PATH', $detail['photo_path']);
            $this->mrTemplate->addVar('current_photo', 'PHOTO_TYPE', $detail['photo_type']);
            $this->mrTemplate->addVar('current_photo', 'PHOTO_SIZE', $detail['photo_size']);

            $this->mrTemplate->addVars('content', $detail);
        }
    }

}

?>