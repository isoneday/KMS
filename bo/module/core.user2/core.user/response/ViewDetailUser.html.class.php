<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailUser extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_user.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjUser = GtfwDispt()->load->business('User', 'core.user');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjUser->getDetailUser($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('core.user', 'user', 'view', 'html').'&display';
        $nav[0]['menu'] = 'User';
        $title = GtfwLangText('detail');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);
        
      	return compact('detail');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
        
        if (!empty($detail)) {
            if ((!empty($detail['photo'])) && is_readable(Configuration::Instance()->GetValue('application', 'aplikan_photo') . $detail['photo_path'])) {
                $path = Configuration::Instance()->GetValue('application', 'aplikan_photo') . $detail['photo_path'];
                if (($detail['photo_type'] == 'jpg') || ($detail['photo_type'] == 'PNG') || ($detail['photo_type'] == 'gif')) {
                    $detail['photo_file'] = "<b><a href=" . $path . " target=_blank> " . $detail['photo'] . "</a></b>";
                    $detail['photop'] = "<img src=" . $path . " width=200px height=170px alt='" . $detail['photo_origin'] . "' title='" . $detail['photo_origin'] . "'>";
                    $this->mrTemplate->SetAttribute('photo_preview', 'visibility', 'visible');
                    $this->mrTemplate->addVar('photo_preview', 'PHOTOP', $detail['photop']);
                } else {
                    $detail['photo_file'] = "<b><a href=" . $path . " target=_blank> " . $detail['photo_origin'] . "</a></b>";
                    $detail['photop'] = '';
                }
                $this->mrTemplate->SetAttribute('current_photo', 'visibility', 'visible');
                $this->mrTemplate->addVar('current_photo', 'PHOTO_FILE', $detail['photo_file']);
            }
          
            $this->mrTemplate->addVars('content', $detail);
        }
   	}
}
?>