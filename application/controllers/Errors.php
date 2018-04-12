<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends CI_Controller {

	
	public function index()
	{
            show_404();
	}
        
        function page_missing(){
            $this->load->view('errors/html/error_page_missing');
        }
}
