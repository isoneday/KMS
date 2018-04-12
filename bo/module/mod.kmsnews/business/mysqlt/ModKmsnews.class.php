<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModKmsnews extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.kmsnews/business/mysqlt/modkmsnews.sql.php');
        $this->SetDebugOn();
    }

    public function countModKmsnews($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($title)) {
            $str .= " AND LOWER(news_title) LIKE('%$title%')";
        }
        if (!empty($status)) {
            $str .= " AND LOWER(news_status) LIKE('%$status%')";
        }
        $query = $this->mSqlQueries['count_modkmsnews'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getModKmsnews($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($title)) {
            $str .= " AND LOWER(news_title) LIKE('%$title%')";
        }
        if (!empty($status)) {
            $str .= " AND LOWER(news_status) LIKE('%$status%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_modkmsnews'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
      // echo "<pre>".$this->GetLastError(); echo "</pre>";
   
        return $result;

    }

    public function getDetailModKmsnews($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modkmsnews'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertModKmsnews($params)
    {
        return $this->Execute($this->mSqlQueries['insert_modkmsnews'], $params);
    }
    
    public function updateModKmsnews($params)
    {
        return $this->Execute($this->mSqlQueries['update_modkmsnews'], $params);
    }
    
    public function deleteModKmsnews($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modkmsnews'], array($id));
    }
    
    public function listModKmsnews()
    {
        return $this->Open($this->mSqlQueries['list_modkmsnews'], array());
    }
}

// End of file ModKmsnews.class.php