<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

	public function index()
	{
		$this->load->model("m_faq");
		$this->load->model("m_news");
		$this->load->model("m_home");
		
		$data['video']    	= $this->m_home->getVideo();
        $data['footer_news']= $this->m_news->getNewsRecent(2);

        $data['title'] 	= 'F.A.Q';
        $data['page']	= 'v_faq';
        $data['faq']	=  $this->m_faq->getItems();
     
        $this->load->view('template/page', $data);
	}
}
