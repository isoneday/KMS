<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class ModForum extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/mod.forum/business/mysqlt/modforum.sql.php');
        $this->SetDebugOn();
    }

    public function countModForum($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($kat_forum)) {
            $str .= " AND LOWER(kat_forum) LIKE('%$kat_forum%')";
        }
        $query = $this->mSqlQueries['count_modforum'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getModForum($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($kat_forum)) {
            $str .= " AND LOWER(kat_forum) LIKE('%$kat_forum%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_modforum'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;

    }

    public function getDetailModForum($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_modforum'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertModForum($params)
    {
        $res= $this->Execute($this->mSqlQueries['insert_modforum'], $params);
    //echo "<pre>".$this->GetLastError();
    return $res;
    }
    
    public function updateModForum($params)
    {
        return $this->Execute($this->mSqlQueries['update_modforum'], $params);
    }
    
    public function deleteModForum($id)
    {
        return $this->Execute($this->mSqlQueries['delete_modforum'], array($id));
    }
    
    public function listModForum()
    {
        return $this->Open($this->mSqlQueries['list_modforum'], array());
    }
}

// End of file ModForum.class.php