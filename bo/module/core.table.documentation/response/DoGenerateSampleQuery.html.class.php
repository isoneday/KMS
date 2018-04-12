<?php
/**
 * @author Prima Noor 
 */

class DoGenerateSampleQuery extends HtmlResponse
{
    function ProcessRequest()
    {
        $table = $_GET['table']->SqlString()->Raw();
        $insert = '';
        if (!empty($table)) {
            $ObjDoc = GtfwDispt()->load->business('Documentation', 'core.table.documentation');
            $column = $ObjDoc->getTableColumn($table);
            if (!empty($column)) {
$insert = 'INSERT INTO '.$table.'
(';           
foreach ($column as $col) {
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
    \''.$col['Field'].'\',';
    }
}
$insert = substr($insert, 0, -1);
$insert .= '
)';            
            }
        }
        echo $insert;
        exit;
    }
}

?>