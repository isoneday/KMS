<?php

/**
 * @author Prima Noor 
 */

class WidgetAnotherSample extends HtmlResponse
{
    function TemplateModule()
    {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/core.test/template');
        $this->SetTemplateFile('widget_another_sample.html');
    }

    function ProcessRequest()
    {
        $ObjTest = GtfwDispt()->load->business('CoreTest', 'core.test');

        $tahun = $_POST['tahun']->Integer()->Raw();
        if (empty($tahun))
            $tahun = date('Y');

        $j = 0;
        for ($i = 2008; $i <= 2015; $i++) {
            $listTahun[$j]['id'] = $i;
            $listTahun[$j]['name'] = $i;
            $j++;
        }
        Messenger::Instance()->SendToComponent('comp.combobox', 'Combobox', 'view', 'html', 'tahun', array(
            'tahun',
            $listTahun,
            $tahun,
            '',
            ' style="display:block; margin:3px auto;"'), Messenger::CurrentRequest);
            
        $data = $ObjTest->getBarangMasukKeluar($tahun);

        return compact('data', 'tahun');
    }

    function ParseTemplate($rdata = null)
    {
        extract($rdata);

        $this->mrTemplate->addVar('content', 'ACTION', GtfwDispt()->GetUrl('core.test', 'anotherSample', 'widget', 'html'));
        if (!empty($data)) {
            $series[0]['name'] = 'Masuk';
            $series[1]['name'] = 'Keluar';
            foreach ($data as $val) {
                $masuk[] = $val['masuk'];
                $keluar[] = $val['keluar'];
            }
            $series[0]['data'] = implode(', ', $masuk);
            $series[1]['data'] = implode(', ', $keluar);

            foreach ($series as $val) {
                $this->mrTemplate->addVars('series', $val);
                $this->mrTemplate->parseTemplate('series', 'a');
            }
        }
    }
}

?>