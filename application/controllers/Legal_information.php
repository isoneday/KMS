<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Legal_information extends CI_Controller {

	public function index()
	{
		$m_legal 		= $this->load->model("m_legal");

        $data['title'] 	= 'Legal Information';
        $data['page']	= 'v_legal';
        $data['legal']	= (array)$this->m_legal->getItems();
        $this->load->view('template/page', $data);
	}
}
