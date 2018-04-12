<?php

class ViewUsername extends HtmlResponse {

    function TemplateModule() {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/core.user/template');
        $this->SetTemplateFile('view_username.html');
    }

    function ProcessRequest() {
        $ObjUser = GtfwDispt()->load->business('User', 'core.user');

        $user_id = Security::Authentication()->GetCurrentUser()->GetUserId();
        $detail = $ObjUser->getUserInfo($user_id);

        return $detail;
    }

    function ParseTemplate($detail = null) {
        if (!empty($detail)) {
            if ((!empty($detail['photo_path'])) && is_readable(Configuration::Instance()->GetValue('application', 'employee_save_path') . $detail['photo_path'])) {
                $path = Configuration::Instance()->GetValue('application', 'employee_save_path') . $detail['photo_path'];
                $detail['profile'] = "<img src=" . $path . " width=90px height=120px alt='" . $detail['photo'] . "' >";
            } else {
                $path_female = Configuration::Instance()->GetValue('application', 'employee_save_path') . 'user-photo-female.jpg';
                $path_male = Configuration::Instance()->GetValue('application', 'employee_save_path') . 'user-photo-male.jpg';
                $path_undf = Configuration::Instance()->GetValue('application', 'employee_save_path') . 'user-photo.png';
                if (!empty($detail['gender'])) {
                    if ($detail['gender'] == 'm') {
                        $detail['profile'] = "<img src=" . $path_male . " width=90px height=120px alt='Male Employee'>";
                    } else {
                        $detail['profile'] = "<img src=" . $path_female . " width=90px height=120px alt='Female Employee'>";
                    }
                } else {
                    $detail['profile'] = "<img src=" . $path_undf . " width=90px height=120px alt='Male Employee'>";
                }
            }
            $this->mrTemplate->addVars('content', $detail);
        }
    }

}

?>
