<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModKms extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.kms/business/mysqlt/modkms.sql.php');
        $this->SetDebugOn();
    }

    public function countModKms($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($judul)) {
            $str .= " AND LOWER(judul) LIKE('%$judul%')";
        }
        $query = $this->mSqlQueries['count_modkms'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getModKms($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($judul)) {
            $str .= " AND LOWER(judul) LIKE('%$judul%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_modkms'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;

    }

    public function getDetailModKms($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modkms'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertModKms($params)
    {
        return $this->Execute($this->mSqlQueries['insert_modkms'], $params);
    }
    
    public function updateModKms($params)
    {
        return $this->Execute($this->mSqlQueries['update_modkms'], $params);
    }
    
    public function deleteModKms($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modkms'], array($id));
    }
    
    public function listModKms()
    {
        return $this->Open($this->mSqlQueries['list_modkms'], array());
    }
}

// End of file ModKms.class.php