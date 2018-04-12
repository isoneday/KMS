<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class CoreMastertypedokumentasi extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.core.mastertypedokumentasi/business/mysqlt/coremastertypedokumentasi.sql.php');
        $this->SetDebugOn();
    }

    public function countCoreMastertypedokumentasi($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($nama_dokumentasi)) {
            $str .= " AND LOWER(nama_dokumentasi) LIKE('%$nama_dokumentasi%')";
        }
        $query = $this->mSqlQueries['count_coremastertypedokumentasi'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getCoreMastertypedokumentasi($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($nama_dokumentasi)) {
            $str .= " AND LOWER(nama_dokumentasi) LIKE('%$nama_dokumentasi%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_coremastertypedokumentasi'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
      //echo "<pre>".$this->GetLastError()."</pre>";die;

        return $result;

    }

    public function getDetailCoreMastertypedokumentasi($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_coremastertypedokumentasi'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertCoreMastertypedokumentasi($params)
    {
        $res= $this->Execute($this->mSqlQueries['insert_coremastertypedokumentasi'], $params);
       // echo "<pre>".$this->GetLastError()."</pre>";die;
        return $res;
    }
    
    public function updateCoreMastertypedokumentasi($params)
    {
        $res= $this->Execute($this->mSqlQueries['update_coremastertypedokumentasi'], $params);
     // echo "<pre>".$this->GetLastError()."</pre>";die;
     return $res;     
    }
    
    public function deleteCoreMastertypedokumentasi($id)
    {
        return $this->Execute($this->mSqlQueries['delete_coremastertypedokumentasi'], array($id));
    }
    
    public function listCoreMastertypedokumentasi()
    {
        return $this->Open($this->mSqlQueries['list_coremastertypedokumentasi'], array());
    }
}

// End of file CoreMastertypedokumentasi.class.php