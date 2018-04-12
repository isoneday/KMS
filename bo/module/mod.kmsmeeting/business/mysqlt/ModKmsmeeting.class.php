    <?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModKmsmeeting extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.kmsmeeting/business/mysqlt/modkmsmeeting.sql.php');
        $this->SetDebugOn();
    }

    public function countModKmsmeeting()
    {

  $query = $this->mSqlQueries['count_modkmsmeeting'];
        $result = $this->Open($query, array());
//     echo "<pre>".$this->GetLastError()."</pre>";die;

  //      print_r($result);die; 

        return $result[0]['total'];
      
    }

    public function getModKmsmeeting($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($topik)) {
            $str .= " AND LOWER(topik) LIKE('%$topik%')";
        }
           if (!empty($kmsmeeting_userid)) {
            $str .= " AND LOWER(kmsmeeting_userid) LIKE('%$kmsmeeting_userid%')";
        }
     
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_modkmsmeeting'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
//echo "<pre>".$this->GetLastError()."</pre>";die;

        return $result;

    }

    public function getDetailModKmsmeeting($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modkmsmeeting'], array($id));
  //echo "<pre>".$this->GetLastError()."</pre>";die;

        if ($result) {
            return $result[0];
        }
    }
    
    
   
    public function insertModKmsmeeting($params)
    {

        $res= $this->Execute($this->mSqlQueries['insert_modkmsmeeting'], $params);
    echo "<pre>".$this->GetLastError();die();
    return $res;
        
    }
    
    public function updateModKmsmeeting($params)
    {
//echo "<pre>".$this->GetLastError()."</pre>";die;

//echo "<pre>".$this->GetLastError()."</pre>";       
        $res= $this->Execute($this->mSqlQueries['update_modkmsmeeting'], $params);

return $res;
    }
    
    public function deleteModKmsmeeting($id)
    {

        $res= $this->Execute($this->mSqlQueries['delete_modkmsmeeting'], array($id));
//echo "<pre>".$this->GetLastError()."</pre>";
   return $res;
    }
    
    public function listModKmsmeeting()
    {
        return $this->Open($this->mSqlQueries['list_modkmsmeeting'], array());
    }
}

// End of file ModKmsmeeting.class.php