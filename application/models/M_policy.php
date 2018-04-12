<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_policy extends CI_Model {

	function getItems()
	{
       $this->db->select("policy_name, policy_info");
       $this->db->from("cms_privacy_policy");

       return $this->db->get()->row();
	}
}
