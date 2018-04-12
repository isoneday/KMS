<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailCoreMastertypedokumentasi extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_coremastertypedokumentasi.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjCoreMastertypedokumentasi = GtfwDispt()->load->business('CoreMastertypedokumentasi', 'mod.core.mastertypedokumentasi');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjCoreMastertypedokumentasi->getDetailCoreMastertypedokumentasi($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.core.mastertypedokumentasi', 'CoreMastertypedokumentasi', 'view', 'html').'&display';
        $nav[0]['menu'] = 'CoreMastertypedokumentasi';
        $title = GtfwLangText('detail');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);
        
      	return compact('detail');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
        
        if (!empty($detail)) {
            $this->mrTemplate->addVars('content', $detail);
        }
   	}
}
?>