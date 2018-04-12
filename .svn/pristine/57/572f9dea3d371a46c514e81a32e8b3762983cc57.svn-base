<?php

/**
 * @author Prima Noor
 */

class Process
{
    var $Obj;
    var $user;
    var $db_type;
    var $cssDone = 'notebox-done';
    var $cssFail = 'notebox-warning';
    var $cssAlert = 'notebox-alert';

    function __construct()
    {
        $this->Obj = GtfwDispt()->load->business('Crud');

        $this->user = Security::Authentication()->GetCurrentUser()->GetUserId();
        
        $dbCfg = GtfwCfg('application', 'db_conn');
        $this->db_type = $dbCfg[0]['db_type'];
    }

    function input()
    {
        $post = $_POST->AsArray();

        $appId = GtfwCfg('application', 'application_id');
        $moduleDir = GtfwCfg('application', 'docroot') . 'module/';


        $Val = GtfwDispt()->load->library('Validation', GtfwCfg('application', 'language'));

//        if (empty($post['new_menu'])) {
//            $Val->set_rules('menu', 'menu', 'required');
//        } else {
        $Val->set_rules('menu', GtfwLangText('menu'), 'required');
//        }
        $Val->set_rules('module', GtfwLangText('module'), 'required|regex_match[/^([-a-z0-9.])+$/i]');
        //$Val->set_rules('class', 'class', 'required|alpha');
        //$Val->set_rules('table', 'table', 'required');
        //$Val->set_rules('default', 'default module', 'required');

        $result = $Val->run();
        if ($result) {
            if (!is_writable($moduleDir)) {
                $msg = 'Module directory not writeable';
                $css = $this->cssFail;
            } elseif (file_exists($moduleDir . $post['module'])) {
                // module already exist
                $msg = 'Module already exist';
                $css = $this->cssFail;
            } else {
                $result = true;
                $this->Obj->StartTrans();

                # ======= db =========
                # -- menu --
//                if ($post['new_menu']) {
//                    $params = array('name' => $post['new_menu'], 'user' => $this->user);
//                    $menuId = $this->Obj->addMenu($params);
//                    $result = $result and !empty($menuId);
//                }

                $menuId = $post['menu'];

                $module = strtolower($post['module']);

                $tmp = explode('.', $module);
                if (is_array($tmp)) {
                    $last = array_pop($tmp);
                    $beforeLast = array_pop($tmp);
                    $class = $beforeLast.ucwords($last);
                } else {
                    $class = $module;
                }
                $uclass = ucwords($class);
                $lclass = strtolower($class);

                $params = array(
                    "mod" => $module,
                    "sub" => '',
                    "act" => '',
                    "typ" => '',
                    "desc" => $post['desc'],
                    "acc" => 'exclusive',
                    "menu_id" => $menuId,
                    "app_id" => $appId,
                    "act_id" => '',
                    "user_id" => $this->user);
                $action = array();
                foreach ($post['action'] as $val) {
                    if (!empty($val['id'])) {
                        $params['sub'] = $val['code'] === 'view' ? $class : str_replace('_', '', $val['code']).$uclass;
                        $params['act_id'] = $val['id'];
                        if (!empty($val['view']) AND $val['view'] == 1) {
                            $params['act'] = 'view';
                            $params['typ'] = 'html';
                            $result = $result and $this->Obj->addModule($params);
                            //echo '<pre>';print_r($this->Obj->GetLastError());echo '</pre>';
                        }
                        if ($val['id'] == $post['default']) {
                            $defaulModuleId = $this->Obj->LastInsertID();
                        }
                        if (!empty($val['do']) AND $val['do'] == 1) {
                            $params['act'] = 'do';
                            $params['typ'] = 'json';
                            $result = $result and $this->Obj->addModule($params);
                            //echo '<pre>';print_r($this->Obj->GetLastError());echo '</pre>';
                        }
                        if (!empty($val['view']) AND $val['view'] == 1 AND $val['code'] === 'view') {
                            $params['sub'] = 'detail'.$uclass;
                            $params['act'] = 'view';
                            $params['typ'] = 'html';
                            $result = $result and $this->Obj->addModule($params);                            
                        }
                        if ($val['id'] == 1 AND !empty($post['combobox'])) {
                            $params['sub'] = 'combo'.$uclass;
                            $params['act'] = 'view';
                            $params['typ'] = 'html';
                            $result = $result and $this->Obj->addModule($params);                            
                        }
                        
                    }
                    if (!empty($val['id']))
                        switch ($val['code']) {
                            case 'view':
                                $action['view'] = true;
                                break;
                            case 'add':
                                $action['add'] = true;
                                break;
                            case 'update':
                                $action['update'] = true;
                                break;
                            case 'delete':
                                $action['delete'] = true;
                                break;
                        }
                }

                if ($result and !empty($defaulModuleId)) {
                    $result = $this->Obj->setDefaultModule($defaulModuleId, $menuId);
                    //echo '<pre>';print_r($this->Obj->GetLastError());echo '</pre>';
                }

                $this->Obj->EndTrans($result);
                //echo '<pre>';print_r($this->Obj->GetLastError());echo '</pre>';
                
                # ======= end of db =========

                # ======= query =============
                $column = $this->Obj->getTableColumn($post['table']);
                
                if (!empty($column) AND !empty($action)) {
                    $parts = explode('_', $column[0]['Field']);
                    $prefix = $parts[0].'_';
                    $query = '';
                    foreach ($action as $act => $val) {
                        switch ($act) {
                            case 'view':
$select = '
$sql["get_' . $lclass . '"] = "
SELECT ';
foreach ($column as $col) {
    $select .= '
    a.'.$col['Field'].' AS `'.str_replace($prefix, '', $col['Field']).'`,';
}
//$select = substr($select, 0, -1);
$select .= '
    IFNULL(CONCAT(b.`user_real_name`,\', \',DATE_FORMAT(a.update_timestamp,\'%d %b %Y %H:%i\')),CONCAT(b.`user_real_name`,\', \',DATE_FORMAT(a.insert_timestamp,\'%d %b %Y %H:%i\'))) AS last_modified
FROM '.$post['table'].' a';
$select .= '
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE
    1 = 1
    --search--
--limit--    
";';

$count = '
$sql["count_' . $lclass . '"] = "
SELECT 
    COUNT('.$column[0]['Field'].') AS total
FROM '.$post['table'];
$count .= '
WHERE
    1 = 1
    --search--
";';

$detail = '
$sql["get_detail_' . $lclass . '"] = "
SELECT ';
foreach ($column as $col) {
    $detail .= '
    a.'.$col['Field'].' AS `'.str_replace($prefix, '', $col['Field']).'`,';
}
//$detail = substr($detail, 0, -1);
$detail .= '
    CONCAT(b.`user_real_name`,\', \',DATE_FORMAT(a.update_timestamp,\'%%d %%b %%Y %%H:%%i\')) AS last_update,
    CONCAT(b.`user_real_name`,\', \',DATE_FORMAT(a.insert_timestamp,\'%%d %%b %%Y %%H:%%i\')) AS last_insert
FROM '.$post['table'].' a';
$detail .= '
LEFT JOIN gtfw_user b ON b.`user_id` = a.`insert_user_id`
WHERE '.$column[0]['Field'].' = %d
";';
$query .= $count.$select.$detail;
                                break;
                            case 'add':
$insert = '
$sql["insert_' . $lclass . '"] = "
INSERT INTO '.$post['table'].'
(';
foreach ($column as $col) {
    if ($col['Field'] === $prefix.'id')
        continue;
    if ($col['Field'] !== 'update_user_id' AND $col['Field'] !== 'update_timestamp'  AND $col['Field'] !== 'unit_id')
    $insert .= '
    '.$col['Field'].',';
}
$insert = substr($insert, 0, -1);
$insert .= '
) VALUES (';
foreach ($column as $col) {
    if ($col['Field'] === $prefix.'id')
        continue;
    if ($col['Field'] !== 'update_user_id' AND $col['Field'] !== 'update_timestamp' AND $col['Field'] !== 'unit_id')
        if ($col['Field'] === 'insert_timestamp') {
    $insert .= '
    NOW(),';} else {
    $insert .= '
    %s,';
    }
}
$insert = substr($insert, 0, -1);
$insert .= '
)
";';       
$query .= $insert;                 
                                break;
                            case 'update':
$update = '
$sql["update_' . $lclass . '"] = "
UPDATE '.$post['table'].'
SET ';
foreach ($column as $col) {
    if ($col['Field'] === $prefix.'id')
        continue;
    if ($col['Field'] !== 'insert_user_id' AND $col['Field'] !== 'insert_timestamp' AND $col['Field'] !== 'unit_id'){
        if ($col['Field'] === 'update_timestamp') {
    $update .= '
    '.$col['Field'].' = NOW(),';       
        } else {
    $update .= '
    '.$col['Field'].' = %s,';
        }
    }
}
$update = substr($update, 0, -1);
$update .= '
WHERE '.$prefix.'id = %d';
$update .= '
";';     
$query .= $update;                       
                                break;
                            case 'delete':
$delete = '
$sql["delete_' . $lclass . '"] = "
DELETE FROM '.$post['table'];
$delete .= '
WHERE '.$prefix.'id = %d';
$delete .= '
";';        
$query .= $delete;                     
                                break;
                        }
                    }
                    if (!empty($post['combobox'])) {
$list = '
$sql["list_'.$lclass.'"] = "
SELECT
    '.$prefix.'id AS `id`,
    '.$prefix.'name AS `name`
FROM
    '.$post['table'].'
ORDER BY '.$prefix.'name
";';
$query .= $list;
                    }
                }
                # ======= files =======
                $colCount = count($column);
                for ($i=0;$i<$colCount;$i++) {
                    if ($column[$i]['Field'] === $prefix.'id' 
                        OR $column[$i]['Field'] === 'insert_user_id'
                        OR $column[$i]['Field'] === 'insert_timestamp'
                        OR $column[$i]['Field'] === 'update_user_id'
                        OR $column[$i]['Field'] === 'update_timestamp'
                        OR $column[$i]['Field'] === 'unit_id'
                    ) {
                        unset($column[$i]);
                    }
                }
                
                if ($result) {
                    $result = $result and mkdir($moduleDir . $post['module']);
                    $result = $result and mkdir($moduleDir . $post['module'] . '/business');
                    if (!empty($this->db_type))
                        $result = $result and mkdir($moduleDir . $post['module'] . '/business/'.$this->db_type);
                    $result = $result and mkdir($moduleDir . $post['module'] . '/response');
                    $result = $result and mkdir($moduleDir . $post['module'] . '/template');
                }

                $templateDir = GtfwCfg('application', 'docroot') . 'module/core.crud/template/';

                $replacer = array(
                    'module' => $post['module'],
                    'class' => $uclass,
                    'lclass' => $lclass);

                if ($result) {
                    # -- business class --
                    $replacer['db_type'] = !empty($this->db_type)?($this->db_type).'/':'';
                    $content = file_get_contents($templateDir . 'tpl_business_class.txt');
                    if ($content) {
                        $replacer['filter'] = '';
                        if (!empty($post['filter'])) {
                            foreach ($post['filter'] as $filter) {
$replacer['filter'] .= '
        if (!empty($'.strtolower(str_replace($prefix, '', $filter)).')) {
            $str .= " AND LOWER('.$filter.') LIKE(\'%$'.strtolower(str_replace($prefix, '', $filter)).'%\')";
        }';                        
                            }
                        }
                        if (is_array($replacer) && sizeof($replacer) > 0) {
                            foreach ($replacer as $k => $v) {
                                $content = str_replace('{' . strtoupper($k) . '}', $v, $content);
                            }
                        }
                        file_put_contents($moduleDir . $post['module'] . '/business/' . $replacer['db_type'] . $replacer['class'] . '.class.php', $content);
                    }
                    
                    # -- sql --
                    $content = file_get_contents($templateDir . 'tpl_business_sql.txt');
                    if ($content) {
                        $content = str_replace('{QUERY}', $query, $content );
                        file_put_contents($moduleDir . $post['module'] . '/business/' . $replacer['db_type'] . $replacer['lclass'] . '.sql.php', $content);
                    }
                    
                    foreach ($action as $act => $val) {
                        if (!empty($post['combobox'])) {
                            # -- response --
                            $content = file_get_contents($templateDir . 'tpl_response_combo.txt');
                            if ($content) {
                                if (is_array($replacer) && sizeof($replacer) > 0) {
                                    $replacer['db_type'] = !empty($this->db_type)?($this->db_type).'/':'';
                                    foreach ($replacer as $k => $v) {
                                        $content = str_replace('{' . strtoupper($k) . '}', $v, $content);
                                    }
                                }
                                file_put_contents($moduleDir . $post['module'] . '/response/ViewCombo' . $replacer['class'] . '.html.class.php', $content);
                            }
                            # -- template --
                            unset($replacer['script']);
                            $content = file_get_contents($templateDir . 'tpl_template_combo.txt');
                            if ($content) {
                                if (is_array($replacer) && sizeof($replacer) > 0) {
                                    $replacer['db_type'] = !empty($this->db_type)?($this->db_type).'/':'';
                                    foreach ($replacer as $k => $v) {
                                        $content = str_replace('{' . strtoupper($k) . '}', $v, $content);
                                    }
                                }
                                file_put_contents($moduleDir . $post['module'] . '/template/view_combo_' . $replacer['lclass'] . '.html', $content);
                            }                            
                        }
                        switch ($act) {
                            case 'view':
                                # -- response view --
                                $content = file_get_contents($templateDir . 'tpl_response_view.txt');
                                if ($content) {
                                    if (is_array($replacer) && sizeof($replacer) > 0) {
                                        $replacer['db_type'] = !empty($this->db_type)?($this->db_type).'/':'';
                                        foreach ($replacer as $k => $v) {
                                            $content = str_replace('{' . strtoupper($k) . '}', $v, $content);
                                        }
                                    }
                                    file_put_contents($moduleDir . $post['module'] . '/response/View' . $replacer['class'] . '.html.class.php', $content);
                                }  
                                # -- template view --
                                $content = file_get_contents($templateDir . 'tpl_template_view.txt');
                                if ($content) {
                                    $replacer['search'] = '';
                                    if (!empty($post['filter'])) {
                                    $replacer['search'] .= '
<form id="form_search" class="xhr dest_subcontent-element dataquest" method="post" action="{URL}">
<table class="table-search">
<tbody>';
                                    foreach ($post['filter'] as $filter) {
                                    $replacer['search'] .= '
    <tr>
        <th style="width:20%;"><!-- patTemplate:gtfwgetlang key="'.(str_replace($prefix, '', $filter)).'" / --></th>
        <td><input type="text" name="'.strtolower(str_replace($prefix, '', $filter)).'" value="{'.strtoupper(str_replace($prefix, '', $filter)).'}" /></td>        
    </tr>';
                                    }
                                    $replacer['search'] .= '
    <tr>
        <th style="width:20%;">&nbsp;</th>
        <td>
            <button class="btn"><!-- patTemplate:gtfwgetlang key="search"/ --></button>
        </td>
    </tr>
</tbody>
</table>
</form>';                                        
                                    }

                                    $replacer['data_header'] = '';
                                    $replacer['data_row'] = '';
                                    $replacer['data_count'] = 2;
                                    if (!empty($post['data'])) {
                                        foreach ($post['data'] as $val) {
                                            $replacer['data_header'] .= "
        <th><!-- patTemplate:gtfwgetlang key=\"".str_replace($prefix, '', $val)."\" / --></th>";
                                            $replacer['data_row'] .= '
        <td>{'.strtoupper(str_replace($prefix, '', $val)).'}</td>';
                                            $replacer['data_count']++;
                                        }
                                    } else {
                                        foreach ($column as $col) {
                                                $replacer['data_header'] .= "
        <th>".str_replace($prefix, '', $col['Field'])."</th>";
                                                $replacer['data_row'] .= '
        <td>{'.strtoupper(str_replace($prefix, '', $col['Field'])).'}</td>';
                                                $replacer['data_count']++;                                      
                                        }
                                    }
                                    if (!empty($post['combobox'])) {
                                        $replacer['class_add'] = 'popup_'.$lclass;
                                        $replacer['script'] = "
    var popup$uclass;
    $('.popup_$lclass').click(function(){
        var url = $(this).attr('href')+'&ascomponent=1';
        var title = $(this).attr('title');
    
        popup$uclass = showGtPopup(url, title);
        return false;
    });
                                        ";
                                    } else {
                                        $replacer['class_add'] = 'xhr dest_subcontent-element';
                                    }
                                    if (is_array($replacer) && sizeof($replacer) > 0) {
                                        $replacer['db_type'] = !empty($this->db_type)?($this->db_type).'/':'';
                                        foreach ($replacer as $k => $v) {
                                            $content = str_replace('{' . strtoupper($k) . '}', $v, $content);
                                        }
                                    }
                                    file_put_contents($moduleDir . $post['module'] . '/template/view_' . $replacer['lclass'] . '.html', $content);
                                } 
                                # -- response detail --
                                $content = file_get_contents($templateDir . 'tpl_response_view_detail.txt');
                                if ($content) {
                                    if (is_array($replacer) && sizeof($replacer) > 0) {
                                        $replacer['db_type'] = !empty($this->db_type)?($this->db_type).'/':'';
                                        foreach ($replacer as $k => $v) {
                                            $content = str_replace('{' . strtoupper($k) . '}', $v, $content);
                                        }
                                    }
                                    file_put_contents($moduleDir . $post['module'] . '/response/ViewDetail' . $replacer['class'] . '.html.class.php', $content);
                                } 
                                # -- template detail --
                                if (empty($post['combobox'])) {
                                    $content = file_get_contents($templateDir . 'tpl_template_view_detail.txt');
                                } else {
                                    $content = file_get_contents($templateDir . 'tpl_template_view_detail_combo.txt');
                                }                                
                                if ($content) {
                                    $replacer['detail_row'] = '';
                                    foreach ($column as $col) {
                                            $replacer['detail_row'] .= '
    <tr>
        <th style="width:200px">'.ucwords(str_replace('_', ' ', str_replace($prefix, '', $col['Field']))).'</th>
        <td>{'.strtoupper(str_replace($prefix, '', $col['Field'])).'}</td>
    </tr>';
                                            $replacer['data_count']++;
//                                        }                                            
                                    }
                                    if (is_array($replacer) && sizeof($replacer) > 0) {
                                        $replacer['db_type'] = !empty($this->db_type)?($this->db_type).'/':'';
                                        foreach ($replacer as $k => $v) {
                                            $content = str_replace('{' . strtoupper($k) . '}', $v, $content);
                                        }
                                    }
                                    file_put_contents($moduleDir . $post['module'] . '/template/view_detail_' . $replacer['lclass'] . '.html', $content);
                                }                           
                                break;
                            case 'add':
                                # -- response add view --
                                $content = file_get_contents($templateDir . 'tpl_response_view_add.txt');
                                if ($content) {
                                    if (is_array($replacer) && sizeof($replacer) > 0) {
                                        $replacer['db_type'] = !empty($this->db_type)?($this->db_type).'/':'';
                                        foreach ($replacer as $k => $v) {
                                            $content = str_replace('{' . strtoupper($k) . '}', $v, $content);
                                        }
                                    }
                                    file_put_contents($moduleDir . $post['module'] . '/response/ViewAdd' . $replacer['class'] . '.html.class.php', $content);
                                } 
                                # -- response add do --
                                if (empty($post['combobox'])) {
                                    $content = file_get_contents($templateDir . 'tpl_response_do_add.txt');
                                } else {
                                    $content = file_get_contents($templateDir . 'tpl_response_do_add_combo.txt');
                                }
                                
                                if ($content) {
                                    if (is_array($replacer) && sizeof($replacer) > 0) {
                                        $replacer['db_type'] = !empty($this->db_type)?($this->db_type).'/':'';
                                        foreach ($replacer as $k => $v) {
                                            $content = str_replace('{' . strtoupper($k) . '}', $v, $content);
                                        }
                                    }
                                    file_put_contents($moduleDir . $post['module'] . '/response/DoAdd' . $replacer['class'] . '.json.class.php', $content);
                                }
                                break;
                            case 'update':
                                # -- response update view --
                                $content = file_get_contents($templateDir . 'tpl_response_view_update.txt');
                                if ($content) {
                                    if (is_array($replacer) && sizeof($replacer) > 0) {
                                        $replacer['db_type'] = !empty($this->db_type)?($this->db_type).'/':'';
                                        foreach ($replacer as $k => $v) {
                                            $content = str_replace('{' . strtoupper($k) . '}', $v, $content);
                                        }
                                    }
                                    file_put_contents($moduleDir . $post['module'] . '/response/ViewUpdate' . $replacer['class'] . '.html.class.php', $content);
                                }
                                # -- response update do --
                                if (empty($post['combobox'])) {
                                    $content = file_get_contents($templateDir . 'tpl_response_do_update.txt');
                                } else {
                                    $content = file_get_contents($templateDir . 'tpl_response_do_update_combo.txt');
                                }
                                if ($content) {
                                    if (is_array($replacer) && sizeof($replacer) > 0) {
                                        $replacer['db_type'] = !empty($this->db_type)?($this->db_type).'/':'';
                                        foreach ($replacer as $k => $v) {
                                            $content = str_replace('{' . strtoupper($k) . '}', $v, $content);
                                        }
                                    }
                                    file_put_contents($moduleDir . $post['module'] . '/response/DoUpdate' . $replacer['class'] . '.json.class.php', $content);
                                }
                                break;
                            case 'delete':
                                # -- response add --
                                $content = file_get_contents($templateDir . 'tpl_response_do_delete.txt');
                                if ($content) {
                                    if (is_array($replacer) && sizeof($replacer) > 0) {
                                        $replacer['db_type'] = !empty($this->db_type)?($this->db_type).'/':'';
                                        foreach ($replacer as $k => $v) {
                                            $content = str_replace('{' . strtoupper($k) . '}', $v, $content);
                                        }
                                    }
                                    file_put_contents($moduleDir . $post['module'] . '/response/DoDelete' . $replacer['class'] . '.json.class.php', $content);
                                }
                                break;
                        }
                    }
                    if ($action['add'] OR $action['update'] OR $action['delete']) {
                        # -- process add --
                        $content = file_get_contents($templateDir . 'tpl_response_process.txt');
                        if ($content) {
                            $replacer['validation_rules'] = '';
                            $replacer['insert_params'] = '';
                            $replacer['update_params'] = '';
                            
                            foreach ($column as $col) {
                                if ($col['Null'] === 'NO') {
                                    $replacer['validation_rules'] .= '
        $Val->set_rules(\''.strtolower(str_replace($prefix, '', $col['Field']))."', GtfwLangText('".str_replace($prefix, '', $col['Field'])."'), 'required');";   
                                }
                                $replacer['insert_params'] .= '
                    $post[\''.strtolower(str_replace($prefix, '', $col['Field'])).'\'],';
                                $replacer['update_params'] .= '
                    $post[\''.strtolower(str_replace($prefix, '', $col['Field'])).'\'],';
                            
                            }
                            $replacer['insert_params'] .= '
                    $this->user';
                            $replacer['update_params'] .= '
                    $this->user,
                    $post[\'id\']';
                            if (is_array($replacer) && sizeof($replacer) > 0) {
                                $replacer['db_type'] = !empty($this->db_type)?($this->db_type).'/':'';
                                foreach ($replacer as $k => $v) {
                                    $content = str_replace('{' . strtoupper($k) . '}', $v, $content);
                                }
                            }
                            file_put_contents($moduleDir . $post['module'] . '/response/Process' . $replacer['class'] . '.proc.class.php', $content);
                        }
                        # -- response input --
                        $content = file_get_contents($templateDir . 'tpl_response_view_input.txt');
                        if ($content) {
                            if (is_array($replacer) && sizeof($replacer) > 0) {
                                $replacer['db_type'] = !empty($this->db_type)?($this->db_type).'/':'';
                                foreach ($replacer as $k => $v) {
                                    $content = str_replace('{' . strtoupper($k) . '}', $v, $content);
                                }
                            }
                            file_put_contents($moduleDir . $post['module'] . '/response/ViewInput' . $replacer['class'] . '.html.class.php', $content);
                        }  
                        # -- template input --
                        if (empty($post['combobox'])) {
                            $content = file_get_contents($templateDir . 'tpl_template_view_input.txt');
                        } else {
                            $content = file_get_contents($templateDir . 'tpl_template_view_input_combo.txt');
                        }
                        
                        if ($content) {
                            $replacer['input_row'] = '';
                            foreach ($column as $col) {
                                if (stripos($col['Type'], 'int')) {
                                    $type = 'number';
                                } elseif (stripos($col['Type'], 'datetime')) {
                                    $type = 'datetime';
                                } elseif (stripos($col['Type'], 'date')) {
                                    $type = 'date';
                                } else {
                                    $type = 'text';
                                }
                                if ($col['Null'] === 'NO') {
                                    $required = TRUE;   
                                } else {
                                    $required = FALSE;
                                }
                                $replacer['input_row'] .= '
    <tr>
        <th style="width: 200px;"><!-- patTemplate:gtfwgetlang key="'.str_replace($prefix, '', $col['Field']).'" / --></th>
        <td>';
if ($col['Type'] === 'text') {
$replacer['input_row'] .= '
            <textarea name="'.strtolower(str_replace($prefix, '', $col['Field'])).'" cols="50" rows="2" '.($required?'required="required"':'').'>{'.strtoupper(str_replace($prefix, '', $col['Field'])).'}</textarea>'.($required?'*':'');
} elseif(stripos($col['Field'], 'status') AND $col['Type'] == 'tinyint(1)'){
$replacer['input_row'] .= '
            <input type="radio" name="'.strtolower(str_replace($prefix, '', $col['Field'])).'" id="'.strtolower(str_replace($prefix, '', $col['Field'])).'1" value="1" checked="" /> <label for="'.strtolower(str_replace($prefix, '', $col['Field'])).'1"><!-- patTemplate:gtfwgetlang key="yes" / --></label>
            <input type="radio" name="'.strtolower(str_replace($prefix, '', $col['Field'])).'" id="'.strtolower(str_replace($prefix, '', $col['Field'])).'0"  value="0" /> <label for="'.strtolower(str_replace($prefix, '', $col['Field'])).'0"><!-- patTemplate:gtfwgetlang key="no" / --></label>'.($required?'*':'');            
} else {
$replacer['input_row'] .= '
            <input type="'.$type.'" name="'.strtolower(str_replace($prefix, '', $col['Field'])).'" value="{'.strtoupper(str_replace($prefix, '', $col['Field'])).'}" '.($required?'required="required"':'').' />'.($required?'*':'');    
}
$replacer['input_row'] .= '            
        </td>
    </tr>';
                            }
                            if (is_array($replacer) && sizeof($replacer) > 0) {
                                $replacer['db_type'] = !empty($this->db_type)?($this->db_type).'/':'';
                                foreach ($replacer as $k => $v) {
                                    $content = str_replace('{' . strtoupper($k) . '}', $v, $content);
                                }
                            }
                            file_put_contents($moduleDir . $post['module'] . '/template/view_input_' . $replacer['lclass'] . '.html', $content);
                        }                   
                    }
                                        
                }


                # ======= end of files =======
                if ($result) {
                    unset($post);
                    $msg = GtfwLangText('msg_add_success');
                    $css = $this->cssDone;
                } else {
                    $msg = GtfwLangText('msg_add_fail');
                    $css = $this->cssFail;
                }
            }
        } else {
            $msg = $Val->error_string('', '<br />');
            $css = $this->cssFail;
        }
        Messenger::Instance()->Send('core.crud', 'module', 'view', 'html', array(
            (!$result)?$post:null,
            $msg,
            $css), Messenger::NextRequest);
        return Dispatcher::Instance()->GetUrl('core.crud', 'module', 'view', 'html');
    }
}

?>