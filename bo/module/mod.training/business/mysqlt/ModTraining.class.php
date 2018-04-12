<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModTraining extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.training/business/mysqlt/modtraining.sql.php');
        $this->SetDebugOn();
    }

    public function countModTraining($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($judul)) {
            $str .= " AND LOWER(judul) LIKE('%$judul%')";
        }
        if (!empty($tanggal)) {
            $str .= " AND LOWER(tanggal) LIKE('%$tanggal%')";
        }
        $query = $this->mSqlQueries['count_modtraining'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getModTraining($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($judul)) {
            $str .= " AND LOWER(judul) LIKE('%$judul%')";
        }
        if (!empty($tanggal)) {
            $str .= " AND LOWER(tanggal) LIKE('%$tanggal%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_modtraining'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
//        echo "<pre>".$this->GetLastError();
        return $result;

    }

    public function getDetailModTraining($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modtraining'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertModTraining($params)
    {
        return $this->Execute($this->mSqlQueries['insert_modtraining'], $params);
    }
    
    public function updateModTraining($params)
    {
        return $this->Execute($this->mSqlQueries['update_modtraining'], $params);
    }
    
    public function deleteModTraining($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modtraining'], array($id));
    }
    
    public function listModTraining()
    {
        return $this->Open($this->mSqlQueries['list_modtraining'], array());
    }
}

// End of file ModTraining.class.php