<?php
/**
 * @author Prima Noor 
 */
 
class CoreWidget extends Database
{

    function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/core.widget/business/mysqlt/corewidget.sql.php');
        $this->SetDebugOn();
    }
    
    public function listAvailableWidget($menuId = NULL, $menuIds = NULL)
    {
        $user_id = Security::Authentication()->GetCurrentUser()->GetUserId();
        
        if (is_array($menuIds)) $menuIds = implode(',', $menuIds);
        $query = $this->mSqlQueries['list_available_widget'];
        $filter_menu = '';
        if (!empty($menuId)) $filter_menu = "AND uwg.userwidget_menu_id = $menuId";
        $filter_menus = '';
        if (!empty($menuIds)) $filter_menus = "AND md.module_menu_id IN ($menuIds)";
        
        $query = str_replace('--filter_menu--', $filter_menu, $query);
        $query = str_replace('--filter_menus--', $filter_menus, $query);
        
        return $this->Open($query, array($user_id, $menuId));
    }
    
    public function getUserWidget($menuId = NULL)
    {
        $user_id = Security::Authentication()->GetCurrentUser()->GetUserId();
        $query = $this->mSqlQueries['get_user_widget'];
        $filter_menu = '';
        if (!empty($menuId)) $filter_menu = "AND wg.userwidget_menu_id = $menuId";
        $query = str_replace('--menu_id--', $filter_menu, $query);
        return $this->Open($query, array($user_id, $menuId));
    }
    
    public function deleteUserWidget($userId, $menuId)
    {
        return $this->Execute($this->mSqlQueries['delete_user_widget'], array($userId, $menuId));
    }
    
    public function saveUserWidget($params)
    {
        return $this->Execute($this->mSqlQueries['insert_user_widget'], $params);
    }
}

?>