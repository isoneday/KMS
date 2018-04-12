<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class CmsFaq extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/cms.faq/business/mysqlt/cmsfaq.sql.php');
        $this->SetDebugOn();
    }

    public function countCmsFaq($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($question)) {
            $str .= " AND LOWER(faq_question) LIKE('%$question%')";
        }
        if (!empty($answer)) {
            $str .= " AND LOWER(faq_answer) LIKE('%$answer%')";
        }
        $query = $this->mSqlQueries['count_cmsfaq'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getCmsFaq($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($question)) {
            $str .= " AND LOWER(faq_question) LIKE('%$question%')";
        }
        if (!empty($answer)) {
            $str .= " AND LOWER(faq_answer) LIKE('%$answer%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_cmsfaq'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;

    }

    public function getDetailCmsFaq($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_cmsfaq'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertCmsFaq($params)
    {
        return $this->Execute($this->mSqlQueries['insert_cmsfaq'], $params);
    }
    
    public function updateCmsFaq($params)
    {
        return $this->Execute($this->mSqlQueries['update_cmsfaq'], $params);
    }
    
    public function deleteCmsFaq($id)
    {
        return $this->Execute($this->mSqlQueries['delete_cmsfaq'], array($id));
    }
    
    public function listCmsFaq()
    {
        return $this->Open($this->mSqlQueries['list_cmsfaq'], array());
    }
}

// End of file CmsFaq.class.php