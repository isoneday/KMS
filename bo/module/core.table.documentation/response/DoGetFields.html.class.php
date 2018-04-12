<?php

/**
 * @author Prima Noor 
 */

class DoGetFields extends HtmlResponse
{
    function ProcessRequest()
    {
        $table = $_GET['table']->SqlString()->Raw();
        
        if (!empty($table)) {
            $ObjDoc = GtfwDispt()->load->business('Documentation', 'core.table.documentation');
            
            $column = $ObjDoc->getTableColumn($table);
            $fields = '<select id="fields" name="fields">';
            if (!empty($column)) {
                foreach ($column as $col) {
                    $fields .= '<option value="'.$col['Field'].'">'.$col['Field'].'</option>';
                }
            }
            $fields .= '</select>';
            echo $fields;
        }
        exit;
    }
}
