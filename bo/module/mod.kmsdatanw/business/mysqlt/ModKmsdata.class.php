<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModKmsdata extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.kmsdata/business/mysqlt/modkmsdata.sql.php');
        $this->SetDebugOn();
    }

    public function countModKmsdata()
    {
        $query = $this->mSqlQueries['count_modkmsdata'];
        $result = $this->Open($query, array());
//     echo "<pre>".$this->GetLastError()."</pre>";die;

  //      print_r($result);die; 

        return $result[0]['total'];
      
    } 

    public function getModKmsdata($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($data)) {
            $str .= " AND LOWER(id_data) LIKE('%$data%')";
        }
        if (!empty($kmsdata_id_kmsdokumen)) {
            $str .= " AND LOWER(kmsdata_id_kmsdokumen) LIKE('%$kmsdata_id_kmsdokumen%')";
        }
        if (!empty($kmsdata_userid)) {
            $str .= " AND LOWER(kmsdata_userid) LIKE('%$kmsdata_userid%')";
        }
        if (!empty($kmsdata_idkategori)) {
            $str .= " AND LOWER(kmsdata_masdok_id) LIKE('%$kmsdata_masdok_id%')";
        }

        if (!empty($kmsdata_keyword)) {
            $str .= " AND (LOWER(kmsdata_keyword) LIKE('%$kmsdata_keyword%')  OR LOWER(c.kategori) LIKE('%$kmsdata_keyword%')OR LOWER(a.filedata_origin) LIKE('%$kmsdata_keyword%'))";
        }
        if (!empty($lam_filedata)) {
            $str .= " AND LOWER(lam_filedata) LIKE('%$lam_filedata%')";
        }
        if (!empty($filedata_enc))  {
            $str .= " AND LOWER(filedata_enc) LIKE('%$filedata_enc%')";
        }
      if (!empty($filedata_origin)) {
            $str .= " AND LOWER(filedata_origin) LIKE('%$filedata_origin%')";
        }
              if (!empty($filedata_path)) {
            $str .= " AND LOWER(filedata_path) LIKE('%$filedata_path%')";
        }
              if (!empty($filedata_type)) {
            $str .= " AND LOWER(filedata_type) LIKE('%$filedata_type%')";
        }
             if (!empty($username)) {
            $str .= " AND LOWER(b.user_user_name) ='$username'";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
      //      $query = $this->mSqlQueries['get_modkmsdata2'&&'get_modkmsdata'];
        $query = $this->mSqlQueries['get_modkmsdata'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
          
        //print_r($_SESSION);die; 
//        $result = $this->Open(stripslashes($query),array()); 
//        $result = $this->Open(stripslashes($query),array());
        $result = $this->Open(stripslashes($query),array());
       
        //echo "<pre>".$this->GetLastError()."</pre>";die;

  //      print_r($result);die; 
      
        return $result;
     
  //      return $result2;
    }

    public function getDetailModKmsdata($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modkmsdata'], array($id));
//   echo "<pre>".$this->GetLastError()."</pre>";die;

        if ($result) {
            return $result[0];
 //echo "<pre>".$this->GetLastError()."</pre>";die;

        }
    }


    public function getNameFileById($id)
    {
        $result = $this->Open($this->mSqlQueries['getNameFileById'], array($id));
        //echo "<pre>".$this->GetLastError()."</pre>";
        if ($result) {
            return $result[0]['name_file'];
        }
    }

  public function addDokGroup($params) {

        $res= $this->Execute($this->mSqlQueries['add_dok_group'], $params, NULL, false);
     //   echo "<pre>".$this->GetLastError()."</pre>";
        return $res;
    }

    
    public function insertModKmsdata($params)
    {
        
    $res = $this->Execute($this->mSqlQueries['insert_modkmsdata'], $params);
    
 //  echo "<pre>".$this->GetLastError(); echo "</pre>";
       return $res;
  
    }
     function GetListFoto($id) {
         $result = $this->Open($this->mSqlQueries['get_foto'], array($id));
       //  echo "<pre>".$this->GetLastError();
     //print_r($result);
       return $result;
     }


  //   public function insertModKmsDokumen($paramsDokumen)
  //   {
        
  //   $res = $this->Execute($this->mSqlQueries['insert_modkmsdokumen'], $paramsDokumen);
    
  //    //echo "<pre>".$this->GetLastError();
  //      return $res;
  // //return $res1;
  
    
  //   }
    // 
    
    public function updateModKmsdata($params)
    {
    
        $result= $this->Execute($this->mSqlQueries['update_modkmsdata'], $params);
    // echo "<pre>".$this->GetLastError();die();
    return $result;
    }
    
    public function deleteModKmsdata($id)
    {
        // echo "<pre>".$this->GetLastError();
     
        return $this->Execute($this->mSqlQueries['delete_modkmsdata'], array($id));
    }
    
    public function listModKmsdata()
    {
  //echo "<pre>".$this->GetLastError();
    
        return $this->Open($this->mSqlQueries['list_modkmsdata'], array());
  
    }
}

// End of file ModKmsdata.class.php