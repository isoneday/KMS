<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class Searchengine extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/searchengine/business/mysqlt/searchengine.sql.php');
        $this->SetDebugOn();
    }

    public function countSearchengine()
    {
        $query = $this->mSqlQueries['count_searchengine'];
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getSearchengine($filter)
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
        $query = $this->mSqlQueries['get_searchengine'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
//echo "<pre>".$this->GetLastError()."</pre>";die;

        return $result;

    }

    public function getDetailSearchengine($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_searchengine'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertSearchengine($params)
    {
        return $this->Execute($this->mSqlQueries['insert_searchengine'], $params);
    }
    
    public function updateSearchengine($params)
    {
        return $this->Execute($this->mSqlQueries['update_searchengine'], $params);
    }
    
    public function deleteSearchengine($id)
    {
        return $this->Execute($this->mSqlQueries['delete_searchengine'], array($id));
    }
    
    public function listSearchengine()
    {
        return $this->Open($this->mSqlQueries['list_searchengine'], array());
    }
}

// End of file Searchengine.class.php