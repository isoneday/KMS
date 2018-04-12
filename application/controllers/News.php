<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

	public function index() {
		$this->load->model("m_news");
		$this->load->model("m_home");
		$search = $this->input->get('search');
		$search = (!empty($search)) ? $search : null;

		$data['video']   	= $this->m_home->getVideo();
	    $data['footer_news']= $this->m_news->getNewsRecent(2);
        $data['title'] 		= 'Beasiswa Pertamina Sobat Bumi | News';
        $data['page'] 		= 'v_news';

        $data['news']		= $this->m_news->getItems(null, $search);
        $this->load->view('template/page', $data);
	}

	public function detail($id = '') {
		$id = (int)$id;
		$this->load->model("m_news");
		$this->load->model("m_home");
		if($id != 0){		
			$data['video']   		= $this->m_home->getVideo();
	        $data['footer_news']    = $this->m_news->getNewsRecent(2);		
			$data['news_content']   = $this->m_news->getItem($id);
           	$data['recent_news']	= $this->m_news->getNewsRecent(3);
           	$data['image_path'] 	= base_url().'bo/files/cms/news/';
           	$data['title']   		= 'Beasiswa Pertamina Sobat Bumi | News';
           	$data['page']    		= 'v_news_detail';
	        $this->load->view('template/page', $data);
	     } else {
	     	redirect('news');
	     }
	}
}
