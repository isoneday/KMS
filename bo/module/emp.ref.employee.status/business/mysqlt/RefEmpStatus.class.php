<?php

/**
 * @author GTFW CRUD Generator 
 */
class RefEmpStatus extends Database {

    public function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/emp.ref.employee.status/business/mysqlt/refempstatus.sql.php');
        $this->SetDebugOn();
    }

    public function countStatus($filter) {        
        $query = $this->mSqlQueries['count_status'];        
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getStatus($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($name)) {
            $str .= " AND LOWER(empstat_name) LIKE('%$name%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";
        }
        $query = $this->mSqlQueries['get_status'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;
    }

    public function getDetailStatus($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_status'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function insertStatus($params) {
        return $this->Execute($this->mSqlQueries['insert_status'], $params);
    }

    public function updateStatus($params) {
        return $this->Execute($this->mSqlQueries['update_status'], $params);
    }

    public function deleteStatus($id) {
        return $this->Execute($this->mSqlQueries['delete_status'], array($id));
    }

    public function listStatus() {
        return $this->Open($this->mSqlQueries['list_status'], array());
    }

	/**
     * check name if exist
     * @param array of name, id
     * @return boolean, true if exist, false otherwise
     */
	
	public function checkField($filter) {
        //var_dump($filter);
		if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($name)) {
		//echo "test";
            $str .= " AND LOWER(empstat_name) = ('$name')";
        }
		 if (!empty($order)) {
            $str .= " AND LOWER(empstat_order) = ('$order')";
        }
		
		if (!empty($id)) {
            $str .= " AND a.empstat_id != $id";
        }
        $limit = '';
		//echo $str;
		
        $query = $this->mSqlQueries['get_status'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        
		// echo "<pre>";
		// echo $this->GetLastError();		
		// echo "</pre>";
		
        if(!empty($result)) { 
		 return true;
		} else {
		 return false ; 
		}				
    }   
}
// End of file Status.class.php