<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModKmsmanagement extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.kmsmanagement/business/mysqlt/modkmsmanagement.sql.php');
        $this->SetDebugOn();
    }

    public function countModKmsmanagement($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($keterangan)) {
            $str .= " AND LOWER(keterangan) LIKE('%$keterangan%')";
        }
        $query = $this->mSqlQueries['count_modkmsmanagement'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getModKmsmanagement($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($keterangan)) {
            $str .= " AND LOWER(keterangan) LIKE('%$keterangan%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_modkmsmanagement'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;

    }

    public function getDetailModKmsmanagement($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modkmsmanagement'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertModKmsmanagement($params)
    {
        return $this->Execute($this->mSqlQueries['insert_modkmsmanagement'], $params);
    }
    
    public function updateModKmsmanagement($params)
    {
        return $this->Execute($this->mSqlQueries['update_modkmsmanagement'], $params);
    }
    
    public function deleteModKmsmanagement($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modkmsmanagement'], array($id));
    }
    
    public function listModKmsmanagement()
    {
        return $this->Open($this->mSqlQueries['list_modkmsmanagement'], array());
    }
}

// End of file ModKmsmanagement.class.php