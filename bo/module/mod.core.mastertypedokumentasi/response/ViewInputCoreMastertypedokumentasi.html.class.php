<?php
/**
 * @author Prima Noor 
 */
   
class ViewInputCoreMastertypedokumentasi extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_input_coremastertypedokumentasi.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjCoreMastertypedokumentasi = GtfwDispt()->load->business('CoreMastertypedokumentasi', 'mod.core.mastertypedokumentasi');
        
        $id = $_GET['id']->Integer()->Raw();
        $elmId = $_GET['elmId']->SqlString()->Raw();
        
        $msg = Messenger::Instance()->Receive(__FILE__);
        $post = isset($msg[0][0])?$msg[0][0]:NULL;
		$message['content'] = isset($msg[0][1])?$msg[0][1]:NULL;
		$message['style'] = isset($msg[0][2])?$msg[0][2]:NULL;
        
        if (!empty($post)) {
            $input = $post;
        } elseif(!empty($id)) {
            $input = $ObjCoreMastertypedokumentasi->getDetailCoreMastertypedokumentasi($id);
        }
        		
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.core.mastertypedokumentasi', 'CoreMastertypedokumentasi', 'view', 'html').'&display';
        $nav[0]['menu'] = GtfwLangText('coremastertypedokumentasi');
        $title = empty($id)?GtfwLangText('add'):GtfwLangText('edit');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);
                
      	return compact('input', 'id', 'message', 'elmId');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
                
		if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }
        
        if (!empty($input)) {
            $this->mrTemplate->addVars('content', $input);
        }
        
        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('mod.core.mastertypedokumentasi', 'CoreMastertypedokumentasi', 'view', 'html').'&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('mod.core.mastertypedokumentasi', (empty($id)?'add':'update').'CoreMastertypedokumentasi', 'do', 'json') . '&elmId=' . $elmId);
   	}
}
?>