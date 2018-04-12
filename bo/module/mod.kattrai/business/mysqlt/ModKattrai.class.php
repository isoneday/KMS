<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModKattrai extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.kattrai/business/mysqlt/modkattrai.sql.php');
        $this->SetDebugOn();
    }

    public function countModKattrai($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($kategori)) {
            $str .= " AND LOWER(kategori) LIKE('%$kategori%')";
        }
        $query = $this->mSqlQueries['count_modkattrai'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getModKattrai($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($kategori)) {
            $str .= " AND LOWER(kategori) LIKE('%$kategori%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_modkattrai'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        echo "<pre>".$this->GetLastError();die();
        return $result;

    }

    public function getDetailModKattrai($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modkattrai'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertModKattrai($params)
    {
        return $this->Execute($this->mSqlQueries['insert_modkattrai'], $params);
    }
    
    public function updateModKattrai($params)
    {
        return $this->Execute($this->mSqlQueries['update_modkattrai'], $params);
    }
    
    public function deleteModKattrai($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modkattrai'], array($id));
    }
    
    public function listModKattrai()
    {
        return $this->Open($this->mSqlQueries['list_modkattrai'], array());
    }
}

// End of file ModKattrai.class.php