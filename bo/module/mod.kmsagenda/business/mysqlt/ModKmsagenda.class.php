<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModKmsagenda extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.kmsagenda/business/mysqlt/modkmsagenda.sql.php');
        $this->SetDebugOn();
    }

    public function countModKmsagenda($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($judul)) {
            $str .= " AND LOWER(judul) LIKE('%$judul%')";
        }
        $query = $this->mSqlQueries['count_modkmsagenda'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getModKmsagenda($filter)
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
        $query = $this->mSqlQueries['get_modkmsagenda'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
     //          echo "<pre>".$this->GetLastError();
    
        return $result;

    }

    public function getDetailModKmsagenda($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modkmsagenda'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertModKmsagenda($params)
    {
        $res = $this->Execute($this->mSqlQueries['insert_modkmsagenda'], $params);
          echo "<pre>".$this->GetLastError();
        return $res;
    }
    
    public function updateModKmsagenda($params)
    {
        return $this->Execute($this->mSqlQueries['update_modkmsagenda'], $params);
    }
    
    public function deleteModKmsagenda($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modkmsagenda'], array($id));
    }
    
    public function listModKmsagenda()
    {
        return $this->Open($this->mSqlQueries['list_modkmsagenda'], array());
    }
}

// End of file ModKmsagenda.class.php