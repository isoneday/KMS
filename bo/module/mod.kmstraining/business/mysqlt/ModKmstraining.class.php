<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModKmstraining extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.kmstraining/business/mysqlt/modkmstraining.sql.php');
        $this->SetDebugOn();
    }

    public function countModKmstraining($filter)
    {
        $query = $this->mSqlQueries['count_modkmstraining'];
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getModKmstraining($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($judul)) {
            $str .= " AND LOWER(judul) LIKE('%$judul%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_modkmstraining'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;

    }

    public function getDetailModKmstraining($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modkmstraining'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertModKmstraining($params)
    {
        $res= $this->Execute($this->mSqlQueries['insert_modkmstraining'], $params);
    echo "<pre>".$this->GetLastError();
      return $res;
    }
    
    public function updateModKmstraining($params)
    {
        return $this->Execute($this->mSqlQueries['update_modkmstraining'], $params);
    }
    
    public function deleteModKmstraining($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modkmstraining'], array($id));
    }
    
    public function listModKmstraining()
    {
        return $this->Open($this->mSqlQueries['list_modkmstraining'], array());
    }
}

// End of file ModKmstraining.class.php