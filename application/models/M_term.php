<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_term extends CI_Model {

	function getItems()
	{
       $this->db->select("term_title, term_content");
       $this->db->from("cms_term");

       return $this->db->get()->row();
	}
}
