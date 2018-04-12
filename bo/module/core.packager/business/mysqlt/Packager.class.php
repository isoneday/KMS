<?php
/**
 * @author Prima Noor 
 */
 
class Packager extends Database
{

    function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/core.packager/business/mysqlt/packager.sql.php');
        $this->SetDebugOn();
    }
    
    /**
     * get module name by menu id
     * @param int menu_id
     * @return string module_name
     */
    public function getModuleName($menu_id)
    {
        $result = $this->Open($this->mSqlQueries['get_module_name'], array($menu_id));
        if (!empty($result)) {
            return $result[0]['module'];
        }
    }
    
    public function getQueryCreateTable($table)
    {
        $result = $this->Open($this->mSqlQueries['show_create_table'], array($table), NULL, false);
        if (!empty($result))
            return $result[0];
    }
    
    public function getAllTableData($table)
    {
        return $this->Open($this->mSqlQueries['get_all_rows'], array($table), NULL, false);
    }
    
    public function getMenus($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        if (!empty($ids)) {
            $str = " AND menu_id IN ($ids)";
        }
        $queery = $this->mSqlQueries['get_menus'];
        $queery = str_replace('--filter--', $str, $queery);
        return $this->Open($queery, array());
    }
    
    public function getMenuTexts($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        if (!empty($ids)) {
            $str = " AND menutext_menu_id IN ($ids)";
        }
        $queery = $this->mSqlQueries['get_menu_texts'];
        $queery = str_replace('--filter--', $str, $queery);
        return $this->Open($queery, array());
    }
    
    public function getModules($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        if (!empty($menu_ids)) {
            $str = " AND module_menu_id IN ($menu_ids)";
        }
        if (!empty($access) AND $access == 'all') {
            $str = " OR module_access = 'all'";
        }
        $queery = $this->mSqlQueries['get_modules'];
        $queery = str_replace('--filter--', $str, $queery);
        return $this->Open($queery, array());
    }
}

?>