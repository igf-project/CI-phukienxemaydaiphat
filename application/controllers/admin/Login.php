<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Login extends CI_controller {

	// Login from admin page
	public function index() {
		$this->load->view('admin/user_view/login_form');
	}
}

?>