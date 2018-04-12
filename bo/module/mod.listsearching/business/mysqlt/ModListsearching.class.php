<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModListsearching extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.listsearching/business/mysqlt/modlistsearching.sql.php');
        $this->SetDebugOn();
    }

    public function countModListsearching($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($kmsdata_keyword)) {
            $str .= " AND LOWER(kmsdata_keyword) LIKE('%$kmsdata_keyword%')";
        }
        $query = $this->mSqlQueries['count_modlistsearching'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getModListsearching($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($kmsdata_keyword)) {
            $str .= " AND LOWER(kmsdata_keyword) LIKE('%$kmsdata_keyword%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_modlistsearching'];
          //      $query2 = $this->mSqlQueries['getOriginFile'];
         $query = str_replace('--search--', $str, $query);
         $query = str_replace('--limit--', $limit, $query);
         $result = $this->Open(stripslashes($query), array($filter['idmasdok']));
     //echo "<pre>".$this->GetLastError();  
        return $result;

    }
    public function getDetailModListsearching($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modlistsearching'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertModListsearching($params)
    {
        return $this->Execute($this->mSqlQueries['insert_modlistsearching'], $params);
    }
    
    public function updateModListsearching($params)
    {
        return $this->Execute($this->mSqlQueries['update_modlistsearching'], $params);
    }
    
    public function deleteModListsearching($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modlistsearching'], array($id));
    }
    
    public function listModListsearching()
    {
        return $this->Open($this->mSqlQueries['list_modlistsearching'], array());
    }
}

// End of file ModListsearching.class.php