<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terms_conditions extends CI_Controller {

	public function index()
	{
		$m_term 		= $this->load->model("m_term");

        $data['title'] 	= 'Terms & Conditions';
        $data['page']	= 'v_term';
        $data['term']	= (array)$this->m_term->getItems();
        $this->load->view('template/page', $data);
	}
}
