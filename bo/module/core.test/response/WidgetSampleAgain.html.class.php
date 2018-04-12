<?php

/**
 * @author Prima Noor 
 */

class WidgetSampleAgain extends HtmlResponse
{
    var $objFormater;
    
    function TemplateModule()
    {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/core.test/template');
        $this->SetTemplateFile('widget_sample_again.html');
    }

    function ProcessRequest()
    {
        $ObjRepCustomerorder = GtfwDispt()->load->business('RepCustomerorder', 'inv.rep.customerorder');
        $ObjSetting                 = GtfwDispt()->load->business('Setting', 'core.setting');
        $this->objFormater          = GtfwDispt()->load->library('Formater');
        $buffer_stock_method        = $ObjSetting->getValue('buffer_stock_method');
        $buffer_value_default       = $ObjSetting->getValue('buffer_stock_period_value');
        $number_format              = $ObjSetting->getValue('number_format');
        
        $post_data = $_POST->AsArray();
        
        $filter['search_period'] = 'monthly';
        if (!empty($post_data)) {
            foreach ($post_data as $key => $value)
		        $filter[$key] = $value; 
        } else {
            $filter['start'] = date('Y-m', strtotime(date('Y-m-d').' -3 months'));
            $filter['end'] = date('Y-m');            
        }
        $filter['month_start'] = substr($filter['start'], 5, 2);
        $filter['year_start'] = substr($filter['start'], 0, 4);
        $filter['month_end'] = substr($filter['end'], 5, 2);
        $filter['year_end'] = substr($filter['end'], 0, 4);
        // get date backward based on monthly
        $month_list = array(
            1 => GtfwLangText('january'),
            2 => GtfwLangText('february'),
            3 => GtfwLangText('march'),
            4 => GtfwLangText('april'),
            5 => GtfwLangText('may'),
            6 => GtfwLangText('june'),
            7 => GtfwLangText('july'),
            8 => GtfwLangText('august'),
            9 => GtfwLangText('september'),
            10 => GtfwLangText('october'),
            11 => GtfwLangText('november'),
            12 => GtfwLangText('december'));

        if (!isset($filter['month_start'])) {
            $today_month = (float)date('m');
            $today_year = (float)date('Y');
            $start_month = $today_month - $buffer_value_default + 1;
            $start_year = $today_year;

            if ($start_month <= 0) {
                $start_month += 12;
                $start_year--;
            }

            if ($start_year == $today_year) {
                for ($i = $start_month; $i <= $today_month; $i++) {
                    $week_period[] = $i;
                }
            } else {
                for ($i = 12; $i >= $start_month; $i--) {
                    $week_period[] = $i;
                }
                for ($i = 1; $i <= $today_month; $i++) {
                    $week_period[] = $i;
                }
            }
        } else {
            if ((float)$filter['year_start'] == $filter['year_end']) {
                for ($i = (float)$filter['month_start']; $i <= (float)$filter['month_end']; $i++) {
                    $week_period[] = $i;
                }
            } else {
                for ($i = 12; $i >= (float)$filter['month_start']; $i--) {
                    $week_period[] = $i;
                }
                for ($i = 1; $i <= (float)$filter['month_end']; $i++) {
                    $week_period[] = $i;
                }
            }
        }

        $data = $ObjRepCustomerorder->getRepCustomerorder($filter);
        
        return compact('data', 'week_period', 'number_format', 'buffer_stock_method', 'filter');
    }

    function ParseTemplate($rdata = null)
    {
        extract($rdata);
        $objForecasting             = GtfwDispt()->load->library('Forecasting');
        
        $this->mrTemplate->addVar('filter', 'ACTION', Dispatcher::Instance()->GetUrl('core.test', 'sampleAgain', 'widget', 'html'));
        if (!empty($filter)) {
            $this->mrTemplate->addVars('filter', $filter);
        }
        
		$period = GtfwLangText('monthly');
        if (!empty($week_period)) {
            $month_list = array (
                 1 => GtfwLangText('january'),
                 2 => GtfwLangText('february'),
                 3 => GtfwLangText('march'),
                 4 => GtfwLangText('april'),
                 5 => GtfwLangText('may'),
                 6 => GtfwLangText('june'),
                 7 => GtfwLangText('july'),
                 8 => GtfwLangText('august'),
                 9 => GtfwLangText('september'),
                 10 => GtfwLangText('october'),
                 11 => GtfwLangText('november'),
                 12 => GtfwLangText('december')
            );
			$first_period = $month_list[$week_period[0]];
            $last_period = $month_list[$week_period[count($week_period)-1]];
            foreach ($week_period as $week_id => $week) {
				$_SESSION['inv.rep.customerorder']['xls_export']['header'][] = $month_list[$week];
                $this->mrTemplate->addVar('period_label', 'LABEL',$month_list[$week]);
                $this->mrTemplate->ParseTemplate('period_label','a');
            }
        }
        
        if (!empty($data) AND count($data)>0) {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'NO');
            $no = 1;
            foreach ($data as $key=>$val) { 
                $buffer = array();
                foreach ($val as $val_id => $item) {
                    $goods_code = $item['GOODS_CODE'];
                    $goods_name = $item['GOODS_NAME'];
                    $unit_name  = $item['UNITS'];
                    break;
                }
				
                $this->mrTemplate->addVar('item','NO', $no);
                $this->mrTemplate->addVar('item','GOODS_CODE', $goods_code);
                $this->mrTemplate->addVar('item','GOODS_NAME', $goods_name);
                $this->mrTemplate->addVar('item','UNITS', $unit_name);
				
				$i = 0;
                foreach ($week_period as $week_id => $week) {
                    if (isset($val[$week])) {
						$_SESSION['inv.rep.customerorder']['xls_export']['data'][$key]['period_'.$i] = $val[$week]['GOODS_QTY'];
                        $this->mrTemplate->addVar('period','GOODS_QTY',$this->objFormater->formatNumber($val[$week]['GOODS_QTY'],$number_format));
                        $this->mrTemplate->parseTemplate('period', 'a');
						
                        $buffer[] = (float)$val[$week]['GOODS_QTY'];
                    } else {
						$_SESSION['inv.rep.customerorder']['xls_export']['data'][$key]['period_'.$i] = 0;
                        $this->mrTemplate->addVar('period','GOODS_QTY',$this->objFormater->formatNumber(0,$number_format));
                        $this->mrTemplate->parseTemplate('period', 'a');
                    
                        $buffer[] = 0;
                    }
					$i++;
                }
                
                if ($buffer_stock_method=='average') {
                    $forecast = $objForecasting->average($buffer);
                }
				
				$_SESSION['inv.rep.customerorder']['xls_export']['data'][$key]['no'] = $no;
				$_SESSION['inv.rep.customerorder']['xls_export']['data'][$key]['code'] = $goods_code;
				$_SESSION['inv.rep.customerorder']['xls_export']['data'][$key]['name'] = $goods_name;
				$_SESSION['inv.rep.customerorder']['xls_export']['data'][$key]['units'] = $unit_name;
				$_SESSION['inv.rep.customerorder']['xls_export']['data'][$key]['forecasting'] = $forecast;
				
                $this->mrTemplate->addVar('item','FORECASTING', $this->objFormater->formatNumber($forecast,$number_format) );
                $this->mrTemplate->parseTemplate('item', 'a');
                $this->mrTemplate->clearTemplate('period',true);
                $no++;
            }
        } else {
            $this->mrTemplate->addVar('data', 'IS_EMPTY', 'YES');
        }
    }
}

?>