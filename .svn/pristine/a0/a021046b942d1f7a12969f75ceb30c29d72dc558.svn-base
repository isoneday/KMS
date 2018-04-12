<?php
/**
 * @author Prima Noor 
 */
 
class Book extends Database
{

    function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/core.sample/business/mysqlt/book.sql.php');
        $this->SetDebugOn();
    }
    
    public function updateBook($params)
    {
        return $this->Execute($this->mSqlQueries['update_book'], $params);
    }
    
    public function getGolonganId($code)
    {
        $result = $this->Open($this->mSqlQueries['get_golongan_id'], array($code));
        if (!empty($result)) {
            return $result[0]['id'];
        } else {
            return NULL;
        }
    }
    
    public function getSeksiId($code)
    {
        $result = $this->Open($this->mSqlQueries['get_seksi_id'], array($code));
        if (!empty($result)) {
            return $result[0]['id'];
        } else {
            $param = array(
                $code
            );
            $result = $this->addSeksi($param);
            
            if ($result)
                return $this->LastInsertId();
            else 
                return NULL;
        }
    }
    
    public function addSeksi($params) 
    {
        return $this->Execute($this->mSqlQueries['add_seksi'], $params);
    }
    
    public function getTingkatId($code)
    {
        $result = $this->Open($this->mSqlQueries['get_tingkat_id'], array($code));
        if (!empty($result)) {
            return $result[0]['id'];
        } else {
            return NULL;
        }
    }
    
    public function getPenerbitId($nama)
    {
        $result = $this->Open($this->mSqlQueries['get_penerbit_id'], array($nama));
        if (!empty($result)) {
            return $result[0]['id'];
        } else {
            $param = array(
                $nama
            );
            $result = $this->addPenerbit($param);
            
            if ($result)
                return $this->LastInsertId();
            else 
                return NULL;
        }        
    }
    
    public function addPenerbit($params)
    {
        return $this->Execute($this->mSqlQueries['add_penerbit'], $params);
    }
}

?>