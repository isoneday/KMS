<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $m_home = $this->load->model("m_home");
        $m_news = $this->load->model("m_news");
    }

    public function index() {
        $data['video']      = $this->m_home->getVideo();
        $data['footer_news']= $this->m_news->getNewsRecent(2);
        $data['banner']     = $this->m_home->getBanner();
        $data['image_path'] = base_url().'bo/files/cms/slider/';  
        $data['title']      = 'Home';
        $data['page']       = 'v_home';

        $this->load->view('template/page', $data);
    }

    public function download_doc() {
        $data['video']      = $this->m_home->getVideo();
        $data['footer_news']= $this->m_news->getNewsRecent(2);
        $data['documents']  = $this->m_home->getDocument();
        $data['doc_path']   = base_url().'bo/files/cms/doc/';
        $data['title']      = 'Beasiswa Pertamina Sobat Bumi | Download Document';
        $data['page']       = 'v_download_doc';

        $this->load->view('template/page', $data);
    }

    function member_check() {
        $email = $this->input->post('merc_email');

        $result = $this->db->query("select * from gtfw_user where user_user_name='" . $email . "'");
        if ($result->num_rows() > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }
}
