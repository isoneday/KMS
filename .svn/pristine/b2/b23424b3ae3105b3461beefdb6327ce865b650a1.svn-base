<?php
/**
 * @author Prima Noor 
 */
   
class ViewInputKey extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_input_key.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjKey = GtfwDispt()->load->business('Key', 'core.lang.key');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $msg = Messenger::Instance()->Receive(__FILE__);
        $post = isset($msg[0][0])?$msg[0][0]:NULL;
		$message['content'] = isset($msg[0][1])?$msg[0][1]:NULL;
		$message['style'] = isset($msg[0][2])?$msg[0][2]:NULL;
		
        if(empty($id)) $lang = $ObjKey->getLang();
		
        if (!empty($post)) {
            foreach ($lang as $key => $val) {
                $lang[$key['translate']] = $post['lang'][$val['kode']];
            }
            array_pop($lang);
            unset($post['lang']);
            $input = $post;
        } elseif(!empty($id)) {
            $input = $ObjKey->getDetailKey($id);
			$lang = $ObjKey->getLangByKey($id);
        }
        		
		$nav[0]['url'] = GtfwDispt()->GetUrl('core.lang.key', 'key', 'view', 'html').'&display';
        $nav[0]['menu'] = GtfwLangText('language');
        $title = empty($id)?GtfwLangText('add'):GtfwLangText('edit');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);
		
      	return compact('input', 'id', 'message','lang');
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
        
        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('core.lang.key', 'key', 'view', 'html').'&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('core.lang.key', (empty($id)?'add':'update').'Key', 'do', 'json'));
   	}
}
?>