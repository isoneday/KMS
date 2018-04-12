<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class TermCondition extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/cms.term.condition/business/mysqlt/termcondition.sql.php');
        $this->SetDebugOn();
    }

    public function countTermCondition($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($title)) {
            $str .= " AND LOWER(term_title) LIKE('%$title%')";
        }
        $query = $this->mSqlQueries['count_termcondition'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getTermCondition($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($title)) {
            $str .= " AND LOWER(term_title) LIKE('%$title%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_termcondition'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;

    }

    public function getDetailTermCondition($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_termcondition'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertTermCondition($params)
    {
        return $this->Execute($this->mSqlQueries['insert_termcondition'], $params);
    }
    
    public function updateTermCondition($params)
    {
        return $this->Execute($this->mSqlQueries['update_termcondition'], $params);
    }
    
    public function deleteTermCondition($id)
    {
        return $this->Execute($this->mSqlQueries['delete_termcondition'], array($id));
    }
    
    public function listTermCondition()
    {
        return $this->Open($this->mSqlQueries['list_termcondition'], array());
    }
}

// End of file TermCondition.class.php