<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_controller extends CI_controller{

	public function __construct(){
		parent:: __construct();
		$this->load->library('session');
		// $this->load->model('admin/Roles_model');
		if ($this->session->has_userdata('LOGIN_ADMIN')==false) {
			header("location: ".base_url()."admin/login");
		}
		// else
		// {
		// 	// Check roles

		// }
	}

}