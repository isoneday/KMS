<?php
/**
 * @author Prima Noor 
 */
   
class ViewTable extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_table.html');
   	}
   
   	function ProcessRequest()
   	{	
   	    $table = $_GET['table']->Raw();
        
        $ObjCrud = GtfwDispt()->load->business('Crud');
        
        if (!empty($table)) {
            $column = $ObjCrud->getTableColumn($table);
        }        
        
      	return compact('column');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
        
        if (!empty($column)) {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'NO');
            foreach ($column as $val) {
                $parts = explode('_', $val['Field']);
                if ($parts[1] == 'id' OR $val['Field'] == 'insert_user_id' OR $val['Field'] == 'insert_timestamp' OR $val['Field'] == 'update_user_id' OR $val['Field'] == 'update_timestamp') {
                    continue;
                }
                $this->mrTemplate->addVar('item_filter', 'FIELD', $val['Field']);
                $this->mrTemplate->parseTemplate('item_filter', 'a');
                $this->mrTemplate->addVar('item_table', 'FIELD', $val['Field']);
                $this->mrTemplate->parseTemplate('item_table', 'a');
            }
        } else {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
        }
   	}
}
?>