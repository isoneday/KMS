<?php
/** 
* @copyright Copyright (c) 2014, PT Gamatechno Indonesia
* @license http://gtfw.gamatechno.com/#license
*/
   
class ViewImportMsProject extends HtmlResponse
{
   	function TemplateModule()
   	{
      	$this->SetTemplateBasedir(Configuration::Instance()->GetValue('application','docroot').'module/'.GtfwDispt()->mModule.'/template');
      	$this->SetTemplateFile('view_import_msproject.html');
   	}
   
   	function ProcessRequest()
   	{	
		$ObjBudgetYear = GtfwDispt()->load->business('BudgetYear', 'ref.budget.year');
		$ObjTransCapex = GtfwDispt()->load->business('TransCapex', 'trans.capex');
		$ObjTransExpense = GtfwDispt()->load->business('TransExpense', 'trans.expense');
		
   	    $msg = Messenger::Instance()->Receive(__FILE__);
        $data = empty($msg[0][0]) ? NULL : $msg[0][0];
        $pesan['pesan'] = empty($msg[0][1]) ? NULL : $msg[0][1];
        $pesan['class'] = empty($msg[0][2]) ? NULL : $msg[0][2];
			
        return compact('pesan', 'data', 'input');
   	}
   
   	function ParseTemplate($rdata = NULL)
   	{
		extract($rdata);
		
		if ($pesan) {
            $this->mrTemplate->SetAttribute('warning_box', 'visibility', 'visible');
            $this->mrTemplate->AddVar('warning_box', 'ISI_PESAN', $pesan['pesan']);
            $this->mrTemplate->AddVar('warning_box', 'CLASS_PESAN', $pesan['class']);
        }
		
		if (!empty($input)) {
            $this->mrTemplate->addVars('content', $input);
        }
		
        $path = GtfwDispt()->GetUrl('ms.project', 'exportMsProject', 'view', 'html');
        $template = "<b><a href=" . $path . " target=_blank> Template Project </a></b>";
        $this->mrTemplate->addVar('content', 'TEMPLATE', $template);
        
        if (!empty($input)) {
            $this->mrTemplate->addVars('content', $input);
        } 
        
        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('ms.project', 'msProject', 'view', 'html').'&display');
        $this->mrTemplate->addVar('content', 'URL_ACTION', Dispatcher::Instance()->getUrl('ms.project', 'importMsProject', 'do', 'html'));
   	}
}
?>