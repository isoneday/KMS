<?php

class CompMenu extends Database {

    public function __construct() {
        parent::__construct();
        $conn = GtfwCfg('application', 'db_conn');
        $this->LoadSql('module/comp.menu/business/' . $conn[0]['db_type'] . '/compmenu.sql.php');
        $this->SetDebugOn();
    }

    public function listMenu($params = NULL) {
        $username = $_SESSION['username'];
        $appId = GtfwCfg('application', 'application_id');
        $lang = GtfwLang()->GetLangCode();

        $query = $this->mSqlQueries['list_menu'];

        $filter = '';
        if (is_array($params)) {
            extract($params);
            if (!empty($name)) {
                $filter .= " AND menutext_menu_name LIKE ('%%$name%%')";
            }
        }

        $query = str_replace('--filter--', $filter, $query);

        return $this->Open($query, array($username, $appId, $lang));
    }

    public function listLandingPageMenu() {
        $username = $_SESSION['username'];
        $appId = GtfwCfg('application', 'application_id');
        $lang = GtfwLang()->GetLangCode();

        return $this->Open($this->mSqlQueries['list_landing_page_menu'], array($username, $appId, $lang));
    }

    public function listModuleMenu() {
        $username = $_SESSION['username'];
        $appId = GtfwCfg('application', 'application_id');
        $lang = GtfwLang()->GetLangCode();

        return $this->Open($this->mSqlQueries['list_module_menu'], array($username, $appId, $lang));
    }

    public function listTopMenu() {
        $username = $_SESSION['username'];
        $appId = GtfwCfg('application', 'application_id');
        $lang = GtfwLang()->GetLangCode();

        return $this->Open($this->mSqlQueries['list_top_menu'], array($username, $appId, $lang));
    }

    public function listMenuModule($mId) {
        $username = $_SESSION['username'];
        $appId = GtfwCfg('application', 'application_id');
        $lang = GtfwLang()->GetLangCode();

        return $this->Open($this->mSqlQueries['list_menu_module'], array($username, $appId, $lang, $mId));
    }

    function getChildrenId($items, $parent, $separator = '|') {
        $result = '';

        foreach ($items as $key => $val) {
            if ($key == $parent) {
                foreach ($val as $value) {
                    $result .= $value['id'] . '|';
                    if (!empty($items[$value['id']])) {
                        $result = $result . $this->getChildrenId($items, $value['id']) . $separator;
                    }
                }
            }
        }

        return substr($result, 0, -(strlen($separator)));
    }

}

?>
