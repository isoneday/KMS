<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class LegalInformation extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/cms.legal.information/business/mysqlt/legalinformation.sql.php');
        $this->SetDebugOn();
    }

    public function countLegalInformation($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($title)) {
            $str .= " AND LOWER(legal_title) LIKE('%$title%')";
        }
        $query = $this->mSqlQueries['count_legalinformation'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getLegalInformation($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($title)) {
            $str .= " AND LOWER(legal_title) LIKE('%$title%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_legalinformation'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;

    }

    public function getDetailLegalInformation($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_legalinformation'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertLegalInformation($params)
    {
        return $this->Execute($this->mSqlQueries['insert_legalinformation'], $params);
    }
    
    public function updateLegalInformation($params)
    {
        return $this->Execute($this->mSqlQueries['update_legalinformation'], $params);
    }
    
    public function deleteLegalInformation($id)
    {
        return $this->Execute($this->mSqlQueries['delete_legalinformation'], array($id));
    }
    
    public function listLegalInformation()
    {
        return $this->Open($this->mSqlQueries['list_legalinformation'], array());
    }
}

// End of file LegalInformation.class.php