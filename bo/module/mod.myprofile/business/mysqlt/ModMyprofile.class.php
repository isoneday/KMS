<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModMyprofile extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.myprofile/business/mysqlt/modmyprofile.sql.php');
        $this->SetDebugOn();
    }

    public function countModMyprofile($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        $query = $this->mSqlQueries['count_modmyprofile'];
       // $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array($_SESSION['username']));
        return $result[0]['total'];
    }

    public function getModMyprofile()
    {
       $query = $this->mSqlQueries['get_modmyprofile'];
    
        // $query = str_replace('--limit--', $limit, $query);
        // $query = str_replace('--search--', $str, $query);
        
        $result = $this->Open(stripslashes($query), array($_SESSION['username']));
      //  echo "<pre>".$this->GetLastError();die();
        return $result;

    }

    public function getDetailModMyprofile($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modmyprofile'], array($id));
        if ($result) {
            return $result[0];
        }
    }
        public function getPhoto($params) {
//echo "<pre>".$this->GetLastError();die();
        
        return $this->Execute($this->mSqlQueries['get_foto'], $params, NULL, false);
    }

    
    public function insertModMyprofile($params)
    {
        return $this->Execute($this->mSqlQueries['insert_modmyprofile'], $params);
    }
    
    public function updateModMyprofile($params)
    {
        return $this->Execute($this->mSqlQueries['update_modmyprofile'], $params);
    }
    
    public function deleteModMyprofile($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modmyprofile'], array($id));
    }
    
    public function listModMyprofile()
    {
        return $this->Open($this->mSqlQueries['list_modmyprofile'], array());
    }
}

// End of file ModMyprofile.class.php