<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModKmsproblem extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.kmsproblem/business/mysqlt/modkmsproblem.sql.php');
        $this->SetDebugOn();
    }

    public function countModKmsproblem($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($problem)) {
            $str .= " AND LOWER(problem) LIKE('%$problem%')";
        }
        if (!empty($person_request)) {
            $str .= " AND LOWER(person_request) LIKE('%$person_request%')";
        }
        if (!empty($person_solving)) {
            $str .= " AND LOWER(person_solving) LIKE('%$person_solving%')";
        }
        $query = $this->mSqlQueries['count_modkmsproblem'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getModKmsproblem($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($problem)) {
            $str .= " AND LOWER(problem) LIKE('%$problem%')";
        }
        if (!empty($person_request)) {
            $str .= " AND LOWER(person_request) LIKE('%$person_request%')";
        }
        if (!empty($person_solving)) {
            $str .= " AND LOWER(person_solving) LIKE('%$person_solving%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_modkmsproblem'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        //echo "<pre>".$this->GetLastError();
        
        return $result;

    }

     function GetListFoto($id) {
         $result = $this->Open($this->mSqlQueries['get_foto'], array($id));
       //  echo "<pre>".$this->GetLastError();
     //print_r($result);
       return $result;
     }
     function GetListFoto2($id) {
         $result = $this->Open($this->mSqlQueries['get_foto2'], array($id));
       //  echo "<pre>".$this->GetLastError();
     //print_r($result);
       return $result;
     }
    function GetListFoto3($id) {
         $result = $this->Open($this->mSqlQueries['get_foto3'], array($id));
       //  echo "<pre>".$this->GetLastError();
     //print_r($result);
       return $result;
     }

    public function getDetailModKmsproblem($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modkmsproblem'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertModKmsproblem($params)
    {
        $res= $this->Execute($this->mSqlQueries['insert_modkmsproblem'], $params);
   // echo "<pre>".$this->GetLastError();
        return $res;
    }
    
    public function updateModKmsproblem($params)
    {
        $res= $this->Execute($this->mSqlQueries['update_modkmsproblem'], $params);
    echo "<pre>".$this->GetLastError();
        return $res;
   
    }
    
    public function deleteModKmsproblem($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modkmsproblem'], array($id));
    }
    
    public function listModKmsproblem()
    {
        return $this->Open($this->mSqlQueries['list_modkmsproblem'], array());
    }
}

// End of file ModKmsproblem.class.php