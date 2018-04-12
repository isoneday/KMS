<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailModKmsproblem extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_modkmsproblem.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjModKmsproblem = GtfwDispt()->load->business('ModKmsproblem', 'mod.kmsproblem');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjModKmsproblem->getDetailModKmsproblem($id);
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('mod.kmsproblem', 'ModKmsproblem', 'view', 'html').'&display';
        $nav[0]['menu'] = 'ModKmsproblem';
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
                     if($val['idstatus'] == 1){
                   // $this->mrTemplate->addVar('content', 'STYLE_JENIS','display:none;'); 
                   // $this->mrTemplate->addVar('item', 'STYLE_JENIS_VALUE','display:none;'); 

                   // $this->mrTemplate->addVar('content', 'STYLE_JUDUL','display:none;'); 
                   // $this->mrTemplate->addVar('item', 'STYLE_JUDUL_VALUE','display:none;'); 
        $this->mrTemplate->addVar('item', 'STYLE_ATC_VALUE');
          $this->mrTemplate->addVar('item', 'STYLE_UPLOAD_VALUE','display:none;'); 
            
                   // $this->mrTemplate->addVar('content', 'STYLE_UPLOAD','display:none;'); 
                }

                 if($val['idstatus'] == 2){
                   $this->mrTemplate->addVar('content', 'STYLE_TYPE_PRODUCT','display:none;'); 
//                   $this->mrTemplate->addVar('item', 'STYLE_PRODUCT_VALUE','display:none;'); 
          $this->mrTemplate->addVar('item', 'STYLE_UPLOAD_VALUE'); 
        $this->mrTemplate->addVar('item', 'STYLE_ATC_VALUE','display:none;');
                   $this->mrTemplate->addVar('content', 'STYLE_JENISS','display:none;'); 

 $this->mrTemplate->addVar('item', 'STYLE_JENISS_VALUE','display:none;'); 
          
                   //  $this->mrTemplate->addVar('content', 'STYLE_ATC','display:none;'); 
                   // $this->mrTemplate->addVar('item', 'STYLE_ATC_VALUE','display:none;');
                }

   	}
}
?>