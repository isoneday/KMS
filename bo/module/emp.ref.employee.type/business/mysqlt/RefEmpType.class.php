<?php

/**
 * @author GTFW CRUD Generator 
 */
class RefEmpType extends Database {

    public function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/emp.ref.employee.type/business/mysqlt/refemptype.sql.php');
        $this->SetDebugOn();
    }

    public function countType($filter) {        
        $query = $this->mSqlQueries['count_type'];        
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getType($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($name)) {
            $str .= " AND LOWER(emptype_name) LIKE('%$name%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";
        }
        $query = $this->mSqlQueries['get_type'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;
    }

    public function getDetailType($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_type'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function insertType($params) {
        return $this->Execute($this->mSqlQueries['insert_type'], $params);
    }

    public function updateType($params) {
        return $this->Execute($this->mSqlQueries['update_type'], $params);
    }

    public function deleteType($id) {
        return $this->Execute($this->mSqlQueries['delete_type'], array($id));
    }

    public function listType() {
        return $this->Open($this->mSqlQueries['list_type'], array());
    }

    public function listTypeToTransfer() {
        return $this->Open($this->mSqlQueries['list_type_to_transfer'], array());
    }
	
	public function checkField($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($name)) {
            $str .= " AND LOWER(emptype_name) = ('$name')";
        }
		if (!empty($order)) {
            $str .= " AND LOWER(emptype_order) = ('$order')";
        }
		
		if (!empty($id)) {
            $str .= " AND a.emptype_id != $id";
        }
        $limit = '';
		
        $query = $this->mSqlQueries['get_type'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
		
        if(!empty($result)) { 
		 return true;
		} else {
		 return false ; 
		}				
    }

}

// End of file Type.class.php