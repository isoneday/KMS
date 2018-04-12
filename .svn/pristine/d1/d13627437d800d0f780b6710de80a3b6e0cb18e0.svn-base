<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class PrivacyPolice extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/cms.privacy.police/business/mysqlt/privacypolice.sql.php');
        $this->SetDebugOn();
    }

    public function countPrivacyPolice($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($name)) {
            $str .= " AND LOWER(policy_name) LIKE('%$name%')";
        }
        $query = $this->mSqlQueries['count_privacypolice'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getPrivacyPolice($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($name)) {
            $str .= " AND LOWER(policy_name) LIKE('%$name%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_privacypolice'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;

    }

    public function getDetailPrivacyPolice($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_privacypolice'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertPrivacyPolice($params)
    {
        return $this->Execute($this->mSqlQueries['insert_privacypolice'], $params);
    }
    
    public function updatePrivacyPolice($params)
    {
        return $this->Execute($this->mSqlQueries['update_privacypolice'], $params);
    }
    
    public function deletePrivacyPolice($id)
    {
        return $this->Execute($this->mSqlQueries['delete_privacypolice'], array($id));
    }
    
    public function listPrivacyPolice()
    {
        return $this->Open($this->mSqlQueries['list_privacypolice'], array());
    }
}

// End of file PrivacyPolice.class.php