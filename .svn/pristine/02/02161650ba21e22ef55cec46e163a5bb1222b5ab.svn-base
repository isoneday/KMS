<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class Language extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/core.language/business/mysqlt/language.sql.php');
        $this->SetDebugOn();
    }

    public function countLanguage($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($name)) {
            $str .= " AND LOWER(lang_name) LIKE('%$name%')";
        }
        $query = $this->mSqlQueries['count_language'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getLanguage($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($name)) {
            $str .= " AND LOWER(lang_name) LIKE('%$name%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_language'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;

    }

    public function getDetailLanguage($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_language'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertLanguage($params)
    {
        return $this->Execute($this->mSqlQueries['insert_language'], $params);
    }
    
    public function updateLanguage($params)
    {
        return $this->Execute($this->mSqlQueries['update_language'], $params);
    }
    
    public function deleteLanguage($id)
    {
        return $this->Execute($this->mSqlQueries['delete_language'], array($id));
    }
    
    public function listLangCode()
    {
        return $this->Open($this->mSqlQueries['list_lang_code'], array());
    }
}

// End of file Language.class.php