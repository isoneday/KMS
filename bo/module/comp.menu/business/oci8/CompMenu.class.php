<?php

class CompMenu extends Database
{

    public function __construct()
    {
        parent::__construct();
        $conn = GtfwCfg('application', 'db_conn');
        $this->LoadSql('module/comp.menu/business/' .$conn[0]['db_type']. '/compmenu.sql.php');
        $this->SetDebugOn();
    }

    function listMenu($username)
    {
        $appId = GtfwCfg('application', 'application_id');
        $lang = $_COOKIE['lang'];
        
        return $this->GetAllDataAsArray($this->mSqlQueries['nav'], array($username, $appId, $lang));
    }
}

?>
