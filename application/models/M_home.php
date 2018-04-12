<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_home extends CI_Model {

	function getVideo() {
		$this->db->select('*');
		$this->db->from('cms_video');

		return  $this->db->get()->row_array();
	}

	function getBanner() {
		$this->db->select('*');
		$this->db->from('cms_slider_banner');
		$this->db->order_by('slider_id', 'DESC');
		$this->db->limit(10);

		return $this->db->get()->result_array();
	}

	function getDocument() {
		$this->db->select('*');
		$this->db->from('cms_document_download');
		$this->db->where('document_status', 1);
		$this->db->limit(10);

		return $this->db->get()->result_array();
	}
}