<?php
/**
 * @author Prima Noor 
 */
 
class CoreTest extends Database
{

    function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/core.test/business/coretest.sql.php');
        $this->SetDebugOn();
    }
    
    function getModuleMenuId($mod, $sub, $act = 'view', $typ = 'html')
    {
        $result = $this->Open($this->mSqlQueries['get_module_menu_id'], array($mod, $sub, $act, $typ));
        if (!empty($result)) {
            return $result[0]['menu_id'];
        }
    }
    
    public function getPersentaseKegagalan()
    {
        $result = $this->Open($this->mSqlQueries['get_presentase_kegagalan'], array());
        if (!empty($result)) {
            return $result[0]['percent'];
        }
    }
    
    public function getBarangMasukKeluar($tahun)
    {
        return $this->Open($this->mSqlQueries['get_barang_masuk_keluar'], array($tahun));
    }
}

?>