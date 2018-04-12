<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModKmsreward extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.kmsreward/business/mysqlt/modkmsreward.sql.php');
        $this->SetDebugOn();
    }

    public function countModKmsreward($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($user)) {
            $str .= " AND LOWER(id_user) LIKE('%$user%')";
        }
        if (!empty($nama_reward)) {
            $str .= " AND LOWER(nama_reward) LIKE('%$nama_reward%')";
        }
        $query = $this->mSqlQueries['count_modkmsreward'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getModKmsreward($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($user)) {
            $str .= " AND LOWER(id_user) LIKE('%$user%')";
        }
        if (!empty($nama_reward)) {
            $str .= " AND LOWER(nama_reward) LIKE('%$nama_reward%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_user'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;

    }

    public function getDetailModKmsreward($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modkmsreward'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertModKmsreward($params)
    {
        return $this->Execute($this->mSqlQueries['insert_modkmsreward'], $params);
    }
    
    public function updateModKmsreward($params)
    {
        return $this->Execute($this->mSqlQueries['update_modkmsreward'], $params);
    }
    
    public function deleteModKmsreward($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modkmsreward'], array($id));
    }
    
    public function listModKmsreward()
    {
        return $this->Open($this->mSqlQueries['list_modkmsreward'], array());
    }
}

// End of file ModKmsreward.class.php