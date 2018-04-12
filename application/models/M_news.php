<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_news extends CI_Model {

	function getItems($limit = 10, $search = null)
	{
       $this->db->select("
       					news_id, 
       					news_title, 
       					news_snippet,
       					news_photo,
       					news_photo_path,
       					user_user_name,
       					a.insert_timestamp as news_date
       	");
       $this->db->from("cms_news as a");
       $this->db->join("gtfw_user as b","b.user_id = a.insert_user_id");
       $this->db->where("news_status",1);
       $this->db->like("news_title", $search, "both");
       $this->db->order_by("a.insert_timestamp", "DESC");
       $this->db->limit($limit);

       return $this->db->get()->result_array();
	}
	function getItem($id){
		$this->db->select("
                news_id, 
                news_title, 
                news_content,
                news_snippet,
                news_photo,
                news_photo_path,
                user_user_name,
                a.insert_timestamp as news_date
        ");
       $this->db->from("cms_news as a");
       $this->db->join("gtfw_user as b","b.user_id = a.insert_user_id");
       $this->db->where("news_id", $id);
       $this->db->where("news_status",1);

       return $this->db->get()->row_array();
	}

  function getNewsRecent($limit = '5')
  {
       $this->db->select("
                news_id, 
                news_title,
                news_snippet, 
                news_photo,
                news_photo_path,
                user_user_name,
                a.insert_timestamp as news_date
        ");
       $this->db->from("cms_news as a");
       $this->db->join("gtfw_user as b","b.user_id = a.insert_user_id");
       $this->db->where("news_status",1);
       $this->db->order_by("news_date","DESC");
       $this->db->limit($limit);

       return $this->db->get()->result_array();
  }
}
