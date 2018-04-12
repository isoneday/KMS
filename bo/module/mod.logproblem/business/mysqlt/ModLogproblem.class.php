<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModLogproblem extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.logproblem/business/mysqlt/modlogproblem.sql.php');
        $this->SetDebugOn();
    }

    public function countModLogproblem($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($problemm)) {
            $str .= " AND LOWER(problemm) LIKE('%$problemm%')";
        }
        if (!empty($person_request)) {
            $str .= " AND LOWER(person_request) LIKE('%$person_request%')";
        }
        if (!empty($person_solving)) {
            $str .= " AND LOWER(person_solving) LIKE('%$person_solving%')";
        }
        if (!empty($status)) {
            $str .= " AND LOWER(status) LIKE('%$status%')";
        }
        $query = $this->mSqlQueries['count_modlogproblem'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getModLogproblem($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($problemm)) {
            $str .= " AND LOWER(problemm) LIKE('%$problemm%')";
        }
        if (!empty($person_request)) {
            $str .= " AND LOWER(person_request) LIKE('%$person_request%')";
        }
        if (!empty($person_solving)) {
            $str .= " AND LOWER(person_solving) LIKE('%$person_solving%')";
        }
        if (!empty($status)) {
            $str .= " AND LOWER(status) LIKE('%$status%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_modlogproblem'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        //echo "<pre>".$this->GetLastError();die();
        
        return $result;

    }

    public function getDetailModLogproblem($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modlogproblem'], array($id));
    //echo "<pre>".$this->GetLastError();
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertModLogproblem($params)
    {
        return $this->Execute($this->mSqlQueries['insert_modlogproblem'], $params);
    }
    
    public function updateModLogproblem($params)
    {
        return $this->Execute($this->mSqlQueries['update_modlogproblem'], $params);
    }
    
    public function deleteModLogproblem($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modlogproblem'], array($id));
    }
    
    public function listModLogproblem()
    {
        return $this->Open($this->mSqlQueries['list_modlogproblem'], array());
    }
}

// End of file ModLogproblem.class.php