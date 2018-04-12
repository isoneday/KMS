<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class MsProject extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/ms.project/business/mysqlt/msproject.sql.php');
        $this->SetDebugOn();
    }

    public function countMsProject()
    {
        $query = $this->mSqlQueries['count_msproject'];
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getMsProject($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($name)) {
            $str .= " AND LOWER(project_name) LIKE('%$name%')";
        }
        if (!empty($code)) {
            $str .= " AND LOWER(project_code) LIKE('%$code%')";
        }
        if (isset($type)) {
			$type = (int)$type;
			if($type < 2)$str .= " AND project_status = '$type'";
        }
        if (!empty($company)) {
            $str .= " AND a.company_id = '$company'";
        }
        
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_msproject'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
		//echo $this->GetLastError();
		//die();
        return $result;

    }

    public function getDetailMsProject($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_msproject'], array($id));
        if ($result) {
            return $result[0];
        }
    }
	
	public function getCompanyId($name)
    {
        $result = $this->Open($this->mSqlQueries['getCompanyId'], array($name));
		//echo "<pre>".$this->GetLastError()."</pre>";
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertMsProject($params)
    {
        $result = $this->Execute($this->mSqlQueries['insert_msproject'], $params);
		//echo "<pre>".$this->GetLastError()."</pre>";
        return $result;
    }
    
    public function updateMsProject($params)
    {
        return $this->Execute($this->mSqlQueries['update_msproject'], $params);
    }
    
    public function deleteMsProject($id)
    {
        return $this->Execute($this->mSqlQueries['delete_msproject'], array($id));
    }
	
	public function replaceProject(){
		return $this->Execute($this->mSqlQueries['replaceProject'], array());
	}
    
    public function listMsProject()
    {
        return $this->Open($this->mSqlQueries['list_msproject'], array());
    }
    
    public function listCompany()
    {
        return $this->Open($this->mSqlQueries['listCompany'], array());
    }
	
}

// End of file MsProject.class.php