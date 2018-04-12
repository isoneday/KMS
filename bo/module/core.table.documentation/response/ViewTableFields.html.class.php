<?php
/**
 * @author Prima Noor 
 */
   
class ViewTableFields extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_table_fields.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $table = $_GET['table']->SqlString()->Raw();
        
        $column = array();
        if (!empty($table)) {
            $ObjDocs = GtfwDispt()->load->business('Documentation', 'core.table.documentation');
            
            $column = $ObjDocs->getTableColumn($table);
            foreach ($column as $row => $value) {
                foreach ($value as $col => $val) {
                    if(!isset($val)) $column[$row][$col] = ' ';
                }
            }
        }
        
      	return compact('column');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
        
        if (!empty($column)) {
            foreach ($column as $col) {
                $this->mrTemplate->addVars('data', $col);
                $this->mrTemplate->parseTemplate('data', 'a');
            }
        }
   	}
}
?>