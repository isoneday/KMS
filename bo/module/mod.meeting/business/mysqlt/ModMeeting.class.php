<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModMeeting extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.meeting/business/mysqlt/modmeeting.sql.php');
        $this->SetDebugOn();
    }

    public function countModMeeting($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($topik)) {
            $str .= " AND LOWER(topik) LIKE('%$topik%')";
        }
        $query = $this->mSqlQueries['count_modmeeting'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getModMeeting($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($topik)) {
            $str .= " AND LOWER(topik) LIKE('%$topik%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_modmeeting'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
//        echo "<pre>".$this->GetLastError();
        return $result;

    }

    public function getDetailModMeeting($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modmeeting'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertModMeeting($params)
    {
        return $this->Execute($this->mSqlQueries['insert_modmeeting'], $params);
    }
    
    public function updateModMeeting($params)
    {
        return $this->Execute($this->mSqlQueries['update_modmeeting'], $params);
    }
    
    public function deleteModMeeting($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modmeeting'], array($id));
    }
    
    public function listModMeeting()
    {
        return $this->Open($this->mSqlQueries['list_modmeeting'], array());
    }
}

// End of file ModMeeting.class.php