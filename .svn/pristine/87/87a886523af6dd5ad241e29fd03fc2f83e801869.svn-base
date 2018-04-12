<?php

/**
 * PT. Gamatechno Indonesia
 * @author apriskiswandi
 */
class Breadcrumb extends Database
{

    protected $mSqlFile = 'module/comp.breadcrump/business/mysqlt/breadcrumb.sql.php';

    function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->setDebugOn();
    }

    function GetIdModule($data)
    {
        $result = $this->Open($this->mSqlQueries['get_id_module'], $data);
        if (!empty($result)) {
            return $result[0];
        } else {
            return null;
        }
    }

    function GetDefaultModuleMenu($data)
    {
        $result = $this->Open($this->mSqlQueries['get_default_module_menu'], $data);
        if (!empty($result)) {
            return $result[0];
        } else {
            return null;
        }

    }

    public function getMenu()
    {
        $username = $_SESSION['username'];
        $appId = GtfwCfg('application', 'application_id');
        $lang = $_COOKIE['lang'];

        return $this->Open($this->mSqlQueries['list_menu'], array(
            $username,
            $appId,
            $lang));
    }
    
    public function getMenuDetail($param)
    {
        $param[] = GtfwLang()->GetLangCode();
        $result = $this->Open($this->mSqlQueries['get_menu_detail'], $param);
        if (!empty($result)) {
            return $result[0];
        }
    }
    // $node is the name of the node we want the path of <br>
    public function getPath($node, $lang)
    {
        // look up the parent of this node
        $row = $this->Open($this->mSqlQueries['get_parent'], array($node, $lang));        
        // save the path in this array
        $path = array();

        // only continue if this $node isn't the root node
        // (that's the node with no parent)
        if ($row[0]['parent_id'] != '') {
            // the last part of the path to $node, is the name
            // of the parent of $node
            $path[] = $row[0];

            // we should add the path to the parent of this node
            // to the path
            $path = array_merge($this->getPath($row[0]['parent_id'], $lang), $path);
        }

        // return the path
        return $path;
    }


}

?>
