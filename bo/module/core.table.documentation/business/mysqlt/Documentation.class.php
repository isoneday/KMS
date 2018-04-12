<?php

/**
 * @author GTFW CRUD Generator 
 */

class Documentation extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/core.table.documentation/business/mysqlt/documentation.sql.php');
        $this->SetDebugOn();
    }

    public function countDocumentation($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($name)) {
            $str .= " AND LOWER(tabledoc_name) LIKE('%$name%')";
        }
        if (!empty($table)) {
            $str .= " AND LOWER(tabledoc_table) LIKE('%$table%')";
        }
        if (!empty($desc)) {
            $str .= " AND LOWER(tabledoc_desc) LIKE('%$desc%')";
        }
        if (!empty($menu_name)) {
            $str .= " AND LOWER(tabledoc_menu_name) LIKE('%$menu_name%')";
        }
        if (!empty($module_name)) {
            $str .= " AND LOWER(tabledoc_module_name) LIKE('%$module_name%')";
        }
        $query = $this->mSqlQueries['count_documentation'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getDocumentation($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($name)) {
            $str .= " AND LOWER(tabledoc_name) LIKE('%$name%')";
        }
        if (!empty($desc)) {
            $str .= " AND LOWER(tabledoc_desc) LIKE('%$desc%')";
        }
        if (!empty($menu_name)) {
            $str .= " AND LOWER(tabledoc_menu_name) LIKE('%$menu_name%')";
        }
        if (!empty($module_name)) {
            $str .= " AND LOWER(tabledoc_module_name) LIKE('%$module_name%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";
        }
        $query = $this->mSqlQueries['get_documentation'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;

    }

    public function getDetailDocumentation($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_documentation'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function insertDocumentation($params)
    {
        return $this->Execute($this->mSqlQueries['insert_documentation'], $params);
    }

    public function updateDocumentation($params)
    {
        return $this->Execute($this->mSqlQueries['update_documentation'], $params);
    }

    public function deleteDocumentation($id)
    {
        return $this->Execute($this->mSqlQueries['delete_documentation'], array($id));
    }

    public function listDocumentation()
    {
        return $this->Open($this->mSqlQueries['list_documentation'], array());
    }

    public function listUndocumentedTable($table = '')
    {
        $return = array();
        $conf = GtfwCfg('application', 'db_conn');
        $dbname = $conf[0]['db_name'];
        $all = $this->Open($this->mSqlQueries['list_table'], array());
        $documented = $this->Open($this->mSqlQueries['get_documented_table'], array());
        if (!empty($all)) {
            foreach ($all as $key => $tables) {
                foreach ($documented as $doc) {
                    if ($tables['Tables_in_' . $dbname] == $doc['name'] AND $doc['name'] !== $table) {
                        unset($all[$key]);
                    }
                }
            }
            foreach ($all as $key => $tables) {
                $return[] = array('id' => $tables['Tables_in_' . $dbname], 'name' => $tables['Tables_in_' . $dbname]);
            }
        }
        return $return;
    }

    public function listTables()
    {
        $return = array();
        $conf = GtfwCfg('application', 'db_conn');
        $dbname = $conf[0]['db_name'];
        $all = $this->Open($this->mSqlQueries['list_table'], array());
        if (!empty($all)) {
            foreach ($all as $key => $tables) {
                $return[] = array('id' => $tables['Tables_in_' . $dbname], 'name' => $tables['Tables_in_' . $dbname]);
            }
        }
        return $return;
    }

    public function getTableColumn($table)
    {
        return $this->Open($this->mSqlQueries['get_table_column'], array($table), null, false);
    }
}

// End of file Documentation.class.php
