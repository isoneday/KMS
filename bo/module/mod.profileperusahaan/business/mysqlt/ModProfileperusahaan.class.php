<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModProfileperusahaan extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.profileperusahaan/business/mysqlt/modprofileperusahaan.sql.php');
        $this->SetDebugOn();
    }

    public function countModProfileperusahaan($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        $query = $this->mSqlQueries['count_modprofileperusahaan'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getModProfileperusahaan($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_modprofileperusahaan'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;

    }

    public function getDetailModProfileperusahaan($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modprofileperusahaan'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertModProfileperusahaan($params)
    {
        return $this->Execute($this->mSqlQueries['insert_modprofileperusahaan'], $params);
    }
    
    public function updateModProfileperusahaan($params)
    {
        return $this->Execute($this->mSqlQueries['update_modprofileperusahaan'], $params);
    }
    
    public function deleteModProfileperusahaan($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modprofileperusahaan'], array($id));
    }
    
    public function listModProfileperusahaan()
    {
        return $this->Open($this->mSqlQueries['list_modprofileperusahaan'], array());
    }
}

// End of file ModProfileperusahaan.class.php