<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_faq extends CI_Model {

	function getItems()
	{
       $this->db->select("faq_id, faq_question, faq_answer");
       $this->db->from("cms_faq");

       return $this->db->get()->result_array();
	}
}
