<?php
/**
 * @author Prima Noor 
 */
 
class Crud extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/core.crud/business/mysqlt/crud.sql.php');
        $this->SetDebugOn();
    }
    
    public function listMenu($lang = 'en')
    {
        return $this->Open($this->mSqlQueries['list_menu'], array($lang));
    }
    
    public function listTable()
    {
        return $this->Open($this->mSqlQueries['list_table'], array());
    } 
    
    public function listActions()
    {
        $lang = GtfwLang()->GetLangCode();
        return $this->Open($this->mSqlQueries['list_actions'], array($lang));
    }
    
    public function getTableColumn($name)
    {
        return $this->Open($this->mSqlQueries['get_table_column'], array($name), NULL, false);
    }
    
    public function addMenu($params)
    {
        $appId = GtfwCfg('application', 'application_id');
        $lang = GtfwLang()->GetLangCode();
        $result = $this->Execute($this->mSqlQueries['add_menu'], array($appId, $params['user']));
        
        $menuId = $this->LastInsertId();
        
        if ($result) {
            $params = array(
                $menuId,
                $lang,
                $params['name'],
                $params['user']
            );
            $result = $result && $this->Execute($this->mSqlQueries['add_menu_text'], $params);
        }
        
        if ($result) {
            return $menuId;
        } else {
            return false;
        }
    }
    
    public function setDefaultModule($moduleId, $menuId)
    {
        return $this->Execute($this->mSqlQueries['set_default_module'], array($moduleId, $menuId));
    }
    
    public function addModule($params)
    {
        return $this->Execute($this->mSqlQueries['add_module'], $params);
    }
}

?>