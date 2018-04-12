<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class CompanyProfile extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/cms.company.profile/business/mysqlt/companyprofile.sql.php');
        $this->SetDebugOn();
    }

    public function countCompanyProfile($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($title)) {
            $str .= " AND LOWER(company_title) LIKE('%$title%')";
        }
        $query = $this->mSqlQueries['count_companyprofile'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getCompanyProfile($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($title)) {
            $str .= " AND LOWER(company_title) LIKE('%$title%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_companyprofile'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;

    }

    public function getDetailCompanyProfile($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_companyprofile'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertCompanyProfile($params)
    {
        return $this->Execute($this->mSqlQueries['insert_companyprofile'], $params);
    }
    
    public function updateCompanyProfile($params)
    {
        return $this->Execute($this->mSqlQueries['update_companyprofile'], $params);
    }
    
    public function deleteCompanyProfile($id)
    {
        return $this->Execute($this->mSqlQueries['delete_companyprofile'], array($id));
    }
    
    public function listCompanyProfile()
    {
        return $this->Open($this->mSqlQueries['list_companyprofile'], array());
    }
}

// End of file CompanyProfile.class.php