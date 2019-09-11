<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_controller {
	public function __construct(){
		parent:: __construct();
		$this->load->library('session');
		if ($this->session->has_userdata('LOGIN_ADMIN')==false) {
			header("location: ".base_url()."admin/login");
		}
	}

	public function index()
	{
		$data = array();
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/layout/home_view');
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}
}
