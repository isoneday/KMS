<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_legal extends CI_Model {

	function getItems()
	{
       $this->db->select("legal_title, legal_content");
       $this->db->from("cms_legal_information");

       return $this->db->get()->row();
	}
}
