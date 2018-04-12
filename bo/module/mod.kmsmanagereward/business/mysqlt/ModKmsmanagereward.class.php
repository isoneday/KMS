<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModKmsmanagereward extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.kmsmanagereward/business/mysqlt/modkmsmanagereward.sql.php');
        $this->SetDebugOn();
    }

    public function countModKmsmanagereward($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($nama_reward)) {
            $str .= " AND LOWER(nama_reward) LIKE('%$nama_reward%')";
        }
        $query = $this->mSqlQueries['count_modkmsmanagereward'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getModKmsmanagereward($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($nama_reward)) {
            $str .= " AND LOWER(nama_reward) LIKE('%$nama_reward%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_modkmsmanagereward'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;

    }

    public function getDetailModKmsmanagereward($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modkmsmanagereward'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertModKmsmanagereward($params)
    {
        $res= $this->Execute($this->mSqlQueries['insert_modkmsmanagereward'], $params);
//echo "<pre>".$this->GetLastError();
return $res;
    }
    
    public function updateModKmsmanagereward($params)
    {
        $res= $this->Execute($this->mSqlQueries['update_modkmsmanagereward'], $params);
    echo "<pre>".$this->GetLastError();
return $res;

    }
    
    public function deleteModKmsmanagereward($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modkmsmanagereward'], array($id));
    }
    
    public function listModKmsmanagereward()
    {
        return $this->Open($this->mSqlQueries['list_modkmsmanagereward'], array());
    }
}

// End of file ModKmsmanagereward.class.php