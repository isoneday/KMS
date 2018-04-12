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

    public function countModKmsdata($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        $query = $this->mSqlQueries['count_modkmsdata'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getModKmsdata($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_modkmsdata'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;

    }

    public function getDetailModKmsdata($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modkmsdata'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertModKmsdata($params)
    {
        return $this->Execute($this->mSqlQueries['insert_modkmsdata'], $params);
    }
    
    public function updateModKmsdata($params)
    {
        return $this->Execute($this->mSqlQueries['update_modkmsdata'], $params);
    }
    
    public function deleteModKmsdata($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modkmsdata'], array($id));
    }
    
    public function listModKmsdata()
    {
        return $this->Open($this->mSqlQueries['list_modkmsdata'], array());
    }
}

// End of file ModKmsdata.class.php