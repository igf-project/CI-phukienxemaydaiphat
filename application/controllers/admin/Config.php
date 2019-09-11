<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		if ($this->session->has_userdata('LOGIN_ADMIN')==false) {
			header("location: ".base_url()."admin/login");
		}
		$this->load->model('admin/Config_model');
		$this->load->library('My_library');
		$this->My_library = new My_library();
	}

	public function index()
	{
		$data = array();
		
		$data['result'] = $this->Config_model->get_list();

		// Show message
		if ($this->session->flashdata('success_message')) {
			$data['success_message'] = $this->My_library->show_message('success', $this->session->flashdata('success_message'));
		}
		if ($this->session->flashdata('error_message')) {
			$data['error_message'] = $this->My_library->show_message('error', $this->session->flashdata('error_message'));
		}

		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/config_view/edit', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	public function update(){
		$data = array(
			'name'			=>	$this->input->post('_name'),
			'title'			=>	$this->input->post('_title'),
			'email'			=>	$this->input->post('_email'),
			'phone'			=>	$this->input->post('_phone'),
			'fax'			=>	$this->input->post('_fax'),
			'facebook'		=>	$this->input->post('_facebook'),
			'youtube'		=>	$this->input->post('_youtube'),
			'gplus'			=>	$this->input->post('_gplus'),
			'address'		=>	$this->input->post('_address'),
			'intro'			=>	$this->input->post('_intro'),
			'meta_keyword'	=>	$this->input->post('_meta_keyword'),
			'meta_descript'	=>	$this->input->post('_meta_descript')
		);
		
		$result = $this->Config_model->update($this->input->post('_id'), $data);
		if($result){
			$this->session->set_flashdata('success_message', 'Cập nhật thành công!');
			redirect('/admin/config/');
		}else{
			$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
			redirect('/admin/config/');
		}
	}
}
