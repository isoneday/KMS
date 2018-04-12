<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privacy_policy extends CI_Controller {

	public function index()
	{
		$m_policy 		= $this->load->model("m_policy");

        $data['title'] 	= 'Privacy Policy';
        $data['page']	= 'v_privacy_policy';
        $data['policy']	= (array)$this->m_policy->getItems();
        $this->load->view('template/page', $data);
	}
}
