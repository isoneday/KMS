<?php
/**
 * @author Prima Noor 
 */
   
class ViewDetailDocumentation extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_detail_documentation.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $ObjDocumentation = GtfwDispt()->load->business('Documentation', 'core.table.documentation');
        
        $id = $_GET['id']->Integer()->Raw();
        
        $source = array();
        $target = array();
        $detail = $ObjDocumentation->getDetailDocumentation($id);
        if (!empty($detail['dependency_source'])) {
            $tables = explode(',', $detail['dependency_source']);
            foreach ($tables as $table) {
                $tmp = explode('|', $table);
                $source[] = array(
                    'table' => $tmp[0],
                    'field' => $tmp[1]
                );
            }
        }
        if (!empty($detail['dependency_target'])) {
            $tables = explode(',', $detail['dependency_target']);
            foreach ($tables as $table) {
                $tmp = explode('|', $table);
                $target[] = array(
                    'table' => $tmp[0],
                    'field' => $tmp[1]
                );
            }
        }
        
		$nav[0]['url'] = GtfwDispt()->GetUrl('core.table.documentation', 'documentation', 'view', 'html').'&display';
        $nav[0]['menu'] = 'Documentation';
        $title = GtfwLangText('detail');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array($title, $nav, 'breadcrump', '', ''), Messenger::CurrentRequest);
        
      	return compact('detail', 'source', 'target');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
        
        if (!empty($detail)) {
            $detail['url'] = GtfwDispt()->GetUrl('core.table.documentation', 'tableFields', 'view', 'html').'&table='.$detail['table'];
            $this->mrTemplate->addVars('content', $detail);
        }
        
        if (!empty($source)) {
            $this->mrTemplate->addVar('source', 'IS_EMPTY', 'NO');
            foreach ($source as $val) {
                $this->mrTemplate->addVars('source_item', $val);
                $this->mrTemplate->parseTemplate('source_item', 'a');
            }
        } else {
            $this->mrTemplate->addVar('source', 'IS_EMPTY', 'YES');
        }
        
        if (!empty($target)) {
            $this->mrTemplate->addVar('target', 'IS_EMPTY', 'NO');
            foreach ($target as $val) {
                $this->mrTemplate->addVars('target_item', $val);
                $this->mrTemplate->parseTemplate('target_item', 'a');
            }
        } else {
            $this->mrTemplate->addVar('target', 'IS_EMPTY', 'YES');
        }
   	}
}
?>