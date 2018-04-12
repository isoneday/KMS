<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailKey extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_key.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjKey = GtfwDispt()->load->business('Key', 'core.lang.key');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $detail = $ObjKey->getDetailKey($id);
		$lang = $ObjKey->getLangByKey($id);
		
        
      	return compact('detail','lang');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
        
        if (!empty($detail)) {
            $this->mrTemplate->addVars('content', $detail);
        }
		
		if(!empty($lang)){
			$this->mrTemplate->addVar('data', 'IS_EMPTY', 'NO');
			$no=1;
			foreach($lang as $key=>$val){
				$val['no']=$no++;
				$this->mrTemplate->addVars('lang', $val);
                $this->mrTemplate->parseTemplate('lang', 'a');
			}
		} else {
			$this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
		}
   	}
}
?>