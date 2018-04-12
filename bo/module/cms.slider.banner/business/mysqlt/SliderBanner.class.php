<?php
/**
 * @author GTFW CRUD Generator 
 */
 
class SliderBanner extends Database
{

    public function __construct($connectionNumber = 0)
    {
        parent::__construct($connectionNumber);
        $this->LoadSql('module/cms.slider.banner/business/mysqlt/sliderbanner.sql.php');
        $this->SetDebugOn();
    }

    public function countSliderBanner($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($title)) {
            $str .= " AND LOWER(slider_title) LIKE('%$title%')";
        }
        $query = $this->mSqlQueries['count_sliderbanner'];
        $query = str_replace('--search--', $str, $query);
        $result = $this->Open($query, array());
        return $result[0]['total'];
    }

    public function getSliderBanner($filter)
    {
        if (is_array($filter))
            extract($filter);
        $str = '';
        
        if (!empty($title)) {
            $str .= " AND LOWER(slider_title) LIKE('%$title%')";
        }
        $limit = '';
        if (!empty($display)) {
            $limit = "LIMIT $start, $display";   
        }
        $query = $this->mSqlQueries['get_sliderbanner'];
        $query = str_replace('--search--', $str, $query);
        $query = str_replace('--limit--', $limit, $query);
        $result = $this->Open(stripslashes($query), array());
        return $result;

    }

    public function getDetailSliderBanner($id)
    {
        $result = $this->Open($this->mSqlQueries['get_detail_sliderbanner'], array($id));
        if ($result) {
            return $result[0];
        }
    }
    
    public function insertSliderBanner($params)
    {
        return $this->Execute($this->mSqlQueries['insert_sliderbanner'], $params);
    }
    
    public function updateSliderBanner($params)
    {
        return $this->Execute($this->mSqlQueries['update_sliderbanner'], $params);
    }
    
    public function deleteSliderBanner($id)
    {
        return $this->Execute($this->mSqlQueries['delete_sliderbanner'], array($id));
    }
    
    public function listSliderBanner()
    {
        return $this->Open($this->mSqlQueries['list_sliderbanner'], array());
    }
}

// End of file SliderBanner.class.php