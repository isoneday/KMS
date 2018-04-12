<?php

/**
 * @author Prima Noor 
 */

class ViewInputDocumentation extends HtmlResponse
{
    function TemplateModule()
    {
        $this->SetTemplateBasedir(Configuration::Instance()->GetValue('application', 'docroot') . 'module/' . GtfwDispt()->mModule . '/template');
        $this->SetTemplateFile('view_input_documentation.html');
    }

    function ProcessRequest()
    {
        $ObjDocumentation = GtfwDispt()->load->business('Documentation', 'core.table.documentation');

        $id = $_GET['id']->Integer()->Raw();
        $elmId = $_GET['elmId']->SqlString()->Raw();

        $msg = Messenger::Instance()->Receive(__file__);
        $post = isset($msg[0][0]) ? $msg[0][0] : null;
        $message['content'] = isset($msg[0][1]) ? $msg[0][1] : null;
        $message['style'] = isset($msg[0][2]) ? $msg[0][2] : null;

        $source = array();
        $target = array();
        if (!empty($post)) {
            if (!empty($post['source_tables'])) {
                foreach ($post['source_tables'] as $key => $val) {
                    $source[] = array(
                        'table' => $val,
                        'field' => $post['source_fields'][$key]
                    );
                }
                unset($post['source_tables']);
                unset($post['source_fields']);
            }
            if (!empty($post['target_tables'])) {
                foreach ($post['target_tables'] as $key => $val) {
                    $target[] = array(
                        'table' => $val,
                        'field' => $post['target_fields'][$key]
                    );
                }
                unset($post['target_tables']);
                unset($post['target_fields']);
            }
            $input = $post;
        } elseif (!empty($id)) {
            $input = $ObjDocumentation->getDetailDocumentation($id);
            if (!empty($input['dependency_source'])) {
                $tables = explode(',', $input['dependency_source']);
                foreach ($tables as $table) {
                    $tmp = explode('|', $table);
                    $source[] = array(
                        'table' => $tmp[0],
                        'field' => $tmp[1]
                    );
                }
            }
            if (!empty($input['dependency_target'])) {
                $tables = explode(',', $input['dependency_target']);
                foreach ($tables as $table) {
                    $tmp = explode('|', $table);
                    $target[] = array(
                        'table' => $tmp[0],
                        'field' => $tmp[1]
                    );
                }
            }
        }

        $listUndocumentedTable = $ObjDocumentation->listUndocumentedTable($input['table']);
        Messenger::Instance()->SendToComponent('comp.combobox', 'Combobox', 'view', 'html', 'table', array(
            'table',
            $listUndocumentedTable,
            $input['table'],
            'false',
            ' style=""'), Messenger::CurrentRequest);
        
        $listTables = $ObjDocumentation->listTables();
        Messenger::Instance()->SendToComponent('comp.combobox', 'Combobox', 'view', 'html', 'source', array(
            'source',
            $listTables,
            '',
            'false',
            ' class="source"'), Messenger::CurrentRequest);
        
        Messenger::Instance()->SendToComponent('comp.combobox', 'Combobox', 'view', 'html', 'target', array(
            'target',
            $listTables,
            '',
            'false',
            ' class="target"'), Messenger::CurrentRequest);

        $nav[0]['url'] = GtfwDispt()->GetUrl('core.table.documentation', 'documentation', 'view', 'html') . '&display';
        $nav[0]['menu'] = GtfwLangText('documentation');
        $title = empty($id) ? GtfwLangText('add') : GtfwLangText('edit');
        Messenger::Instance()->SendToComponent('comp.breadcrump', 'breadcrump', 'view', 'html', 'breadcrump', array(
            $title,
            $nav,
            'breadcrump',
            '',
            ''), Messenger::CurrentRequest);

        return compact('input', 'id', 'message', 'source', 'target');
    }

    function ParseTemplate($rdata = null)
    {
        extract($rdata);

        if (!empty($message)) {
            $this->mrTemplate->addVars('message', $message);
        }

        if (!empty($input)) {
            $this->mrTemplate->addVars('content', $input);
        }
        
        if (!empty($source)) {
            $this->mrTemplate->addVar('source', 'IS_EMPTY', 'NO');
            foreach ($source as $val) {
                $this->mrTemplate->addVars('source_item', $val);
                $this->mrTemplate->parseTemplate('source_item', 'a');
            }
        }
        
        if (!empty($target)) {
            $this->mrTemplate->addVar('target', 'IS_EMPTY', 'NO');
            foreach ($target as $val) {
                $this->mrTemplate->addVars('target_item', $val);
                $this->mrTemplate->parseTemplate('target_item', 'a');
            }
        }

        $this->mrTemplate->addVar('content', 'URL_BACK', GtfwDispt()->GetUrl('core.table.documentation', 'documentation', 'view', 'html') . '&display');
        $this->mrTemplate->addVar('content', 'URL', GtfwDispt()->GetUrl('core.table.documentation', (empty($id) ? 'add' : 'update') . 'Documentation', 'do', 'json') . '&elmId=' . $elmId);
        $this->mrTemplate->addVar('content', 'URL_SAMPLE_DATA', GtfwDispt()->GetUrl('core.table.documentation', 'generateSampleQuery', 'do', 'html'));
        $this->mrTemplate->addVar('content', 'URL_FIELDS', GtfwDispt()->GetUrl('core.table.documentation', 'getFields', 'do', 'html'));
    }
}

?>