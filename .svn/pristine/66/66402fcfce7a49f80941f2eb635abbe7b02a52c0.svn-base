<?php

/**
 * @author Prima Noor 
 */
class ViewDetailCoreCompany extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_detail_corecompany.html');
    }

    function ProcessRequest() {
        $ObjCoreCompany = GtfwDispt()->load->business('CoreCompany', 'core.company');

        $id = $_GET['id']->Integer()->Raw();

        $detail = $ObjCoreCompany->getDetailCoreCompany($id);
        $photo = $ObjCoreCompany->getPhotoTypeById($id);

        return compact('detail', 'photo');
    }

    function ParseTemplate($rdata = NULL) {
        extract($rdata);

        if (!empty($detail)) {
            $this->mrTemplate->addVar('photo_type', 'EMPTY', 'NO');
            $i = 0;
            for ($i = 0; $i < sizeof($photo); $i++) {

                $photo[$i]['no'] = $i + 1;
                $photo[$i]['key'] = $i;

                if ((!empty($photo[$i]['photo_ori'])) && is_readable(Configuration::Instance()->GetValue('application', 'master_save_path') . $photo[$i]['photo_enc'])) {
                    $path = Configuration::Instance()->GetValue('application', 'master_save_path') . $photo[$i]['photo_enc'];
                    $photo[$i]['preview'] = "<img src=" . $path . " width=110px height=140px alt='" . $photo[$i]['photo_ori'] . "' title='" . $photo[$i]['photo_ori'] . "'>";
                    $this->mrTemplate->AddVars('prev_file', $photo[$i]);
                } else {
                    $photo[$i]['note'] = GtfwLangText('there_is_no_current_file');
                }
                $this->mrTemplate->addVars('item_photo', $photo[$i]);
                $this->mrTemplate->parseTemplate('item_photo', 'a');
            }
            $this->mrTemplate->addVars('content', $detail);
        }
    }

}

?>