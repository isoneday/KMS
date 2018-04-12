<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class CmsNews extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/cms.news/business/mysqlt/cmsnews.sql.php');
        $this->SetDebugOn();
    }

    public function countCmsNews($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($title)) {
            $str .= " AND LOWER(news_title) LIKE('%$title%')";
        }
        if (!empty($content)) {
            $str .= " AND LOWER(news_content) LIKE('%$content%')";
        }
        $query = $this->mSqlQueries['count_cmsnews'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getCmsNews($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($title)) {
            $str .= " AND LOWER(news_title) LIKE('%$title%')";
        }
        if (!empty($content)) {
            $str .= " AND LOWER(news_content) LIKE('%$content%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_cmsnews'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;

    }

    public function getDetailCmsNews($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_cmsnews'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertCmsNews($params)
    {
        return $this->Execute($this->mSqlQueries['insert_cmsnews'], $params);
    }
    
    public function updateCmsNews($params)
    {
        return $this->Execute($this->mSqlQueries['update_cmsnews'], $params);
    }
    
    public function deleteCmsNews($id)
    {
        return $this->Execute($this->mSqlQueries['delete_cmsnews'], array($id));
    }
    
    public function listCmsNews()
    {
        return $this->Open($this->mSqlQueries['list_cmsnews'], array());
    }
}

// End of file CmsNews.class.php