<?php

/**
 * @author GTFW CRUD Generator 
 */
class CoreCompany extends Database {

    public function __construct($connectionNumber = 0) {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/core.company/business/mysqlt/corecompany.sql.php');
        $this->SetDebugOn();
    }

    public function countCoreCompany() {
        $query = $this->mSqlQueries['count_corecompany'];
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getCoreCompany($filter) {
        if (is_array($filter))
            extract($filter);
        $str = '';

        if (!empty($name)) {
            $str .= " AND LOWER(company_name) LIKE('%$name%') OR LOWER(company_phone) LIKE('%$name%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";
        }
        $query = $this->mSqlQueries['get_corecompany'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;
    }

    public function getDetailCoreCompany($id) {
        $result = $this->Open($this->mSqlQueries['get_detail_corecompany'], array($id));
        if ($result) {
            return $result[0];
        }
    }

    public function insertCoreCompany($params) {
        return $this->Execute($this->mSqlQueries['insert_corecompany'], $params);
    }

    public function updateCoreCompany($params) {
        return $this->Execute($this->mSqlQueries['update_corecompany'], $params);
    }

    public function deleteCoreCompany($id) {
        return $this->Execute($this->mSqlQueries['delete_corecompany'], array($id));
    }

    public function listCoreCompany() {
        return $this->Open($this->mSqlQueries['list_company'], array());
    }

    public function getPhotoType() {
        return $this->Open($this->mSqlQueries['get_photo_type'], array());
    }

    public function getPhotoTypeById($id) {
        $result = $this->Open($this->mSqlQueries['get_photo_type_by_id'], array($id, $id, $id));
        return $result;
    }

    public function insertCompanyPhoto($params) {
        $result = $this->Execute($this->mSqlQueries['insert_company_photo'], $params);
        return $result;
    }

    public function updateCompanyPhoto($params) {
        $result = $this->Execute($this->mSqlQueries['update_company_photo'], $params);
        return $result;
    }

    public function getCompanyPhoto($id, $type) {
        $result = $this->Open($this->mSqlQueries['get_company_photo'], array($id, $type));
        return $result;
    }

    public function deleteCompanyPhoto($id, $type) {
        $result = $this->Execute($this->mSqlQueries['delete_company_photo'], array($id, $type));
        return $result;
    }

    public function listCompanyToTaf() {
        return $this->Open($this->mSqlQueries['list_company_to_taf'], array());
    }

    public function listCompanyTransaction() {
        return $this->Open($this->mSqlQueries['list_company_transaction'], array());
    }

}

// End of file CoreCompany.class.php