<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModProfilekaryawan extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.profilekaryawan/business/mysqlt/modprofilekaryawan.sql.php');
        $this->SetDebugOn();
    }

    public function countModProfilekaryawan($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($jenis_kelamin)) {
            $str .= " AND LOWER(jenis_kelamin) LIKE('%$jenis_kelamin%')";
        }
        if (!empty($real_name)) {
            $str .= " AND LOWER(user_real_name) LIKE('%$real_name%')";
        }
        $query = $this->mSqlQueries['count_modprofilekaryawan'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getModProfilekaryawan($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($jenis_kelamin)) {
            $str .= " AND LOWER(jenis_kelamin) LIKE('%$jenis_kelamin%')";
        }
        if (!empty($real_name)) {
            $str .= " AND LOWER(user_real_name) LIKE('%$real_name%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_modprofilekaryawan'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
  //       echo "<pre>".$this->GetLastError()."</pre>";
    //            echo "<pre>".$this->GetLastError();
  
   return $result;

    }

    public function getDetailModProfilekaryawan($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modprofilekaryawan'], array($id));
  
   //    echo "<pre>".$this->GetLastError()."</pre>";
         if ($result) {
      
            return $result[0];
        }
    }
    
    public function insertModProfilekaryawan($params)
    {
        return $this->Execute($this->mSqlQueries['insert_modprofilekaryawan'], $params);
    }
    
    public function updateModProfilekaryawan($params)
    {
        return $this->Execute($this->mSqlQueries['update_modprofilekaryawan'], $params);
    }
    
    public function deleteModProfilekaryawan($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modprofilekaryawan'], array($id));
    }
    
    public function listModProfilekaryawan()
    {
        return $this->Open($this->mSqlQueries['list_modprofilekaryawan'], array());
    }
}

// End of file ModProfilekaryawan.class.php