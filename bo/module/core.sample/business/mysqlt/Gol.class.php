<?php
/**
 * @author Prima Noor 
 */
 
class Gol extends Database
{

    function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/core.sample/business/mysqlt/gol.sql.php');
        $this->SetDebugOn();
    }
    
    public function isKategori($kode)
    {
        $result = $this->Open($this->mSqlQueries['get_kategori_by_code'], array($kode));
        if (!empty($result)) {
            return true;
        }
    }
    
    public function addGolongan($params)
    {
        return $this->Execute($this->mSqlQueries['add_golongan'], $params);
    }
}

?>