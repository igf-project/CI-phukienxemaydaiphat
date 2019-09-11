<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		if ($this->session->has_userdata('LOGIN_ADMIN')==false) {
			header("location: ".base_url()."admin/login");
		}
		$this->load->model('admin/Roles_model');
		$this->load->library('My_library');
		$this->My_library = new My_library();
	}

	public function index(){
		$data = array();
		$where = '1=1';
		$par_id = '0';
		$order = NULL;

		/* GET */
		$parameters = $this->input->get();
		$data['q'] = isset($parameters['q']) ? $parameters['q'] : '';
		$data['action'] = isset($parameters['action']) ? $parameters['action'] : 'all';
		
		if($data['q'] != '' OR ($data['action'] != '' AND $data['action'] != 'all')){
			$par_id = NULL;
			if($data['q'] != ''){
				$where .= " AND firstname LIKE '%".$data['q']."%' OR lastname LIKE '%".$data['q']."%'";
			}
			if($data['action'] != '' AND $data['action'] != 'all'){
				$where .= " AND isactive='".$data['action']."'";
			}
		}
		
		/* End GET */
		/* Set Pagging */
		$limit_per_page = 25;
		$uri_segment 	= 4;
		$num_links		= 3;
		$base_url 		= base_url().'admin/Roles/index/';
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		$total_records 	= $this->Roles_model->count_all('par_id = 0');

		if ($total_records > 0)
		{
			$data["links"] = $this->My_library->paging($total_records, $limit_per_page, $uri_segment, $num_links, $base_url);
		}
		/* End Set Pagging */
		$data["users"] = $this->Roles_model->rows($where, $order, $page, $limit_per_page, $par_id);
		/* Show message */
		if ($this->session->flashdata('success_message')) {
			$data['success_message'] = $this->My_library->show_message('success', $this->session->flashdata('success_message'));
		}
		if ($this->session->flashdata('error_message')) {
			$data['error_message'] = $this->My_library->show_message('error', $this->session->flashdata('error_message'));
		}
		/* End Show message */

		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/Roles_view/list', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Add form
	public function add(){
		$data = array();
		$data['parent'] = $this->Roles_model->getListCbItem();
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/Roles_view/add', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Save add form
	public function do_add(){
		$data = array(
			'name'			=>	$this->input->post('_name'),
			'par_id'		=>	$this->input->post('cbo_group'),
			'intro'			=>	$this->input->post('_intro')
		);
		$result = $this->Roles_model->add_new($data);
		if($result){
			$this->session->set_flashdata('success_message', 'Thêm mới thành công!');
			redirect('/admin/Roles/');
		}else{
			$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
			redirect('/admin/Roles/');
		}
	}

	// Edit form
	public function edit($id){
		$data = array();
		$data['id'] = $id;
		$data['parent'] = $this->Roles_model->getListCbItem();
		$data['result'] = $this->Roles_model->getOne($id);
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/Roles_view/edit', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Save edit form
	public function do_edit(){
		$id = (int)$this->input->post('txtid');
		$data 	= 	array(
			'name'		=>	addslashes($this->input->post('_name')),
			'par_id'	=>	addslashes($this->input->post('cbo_group')),
			'intro'		=>	addslashes($this->input->post('_intro'))
		);
		$result = $this->Roles_model->update($id, $data);
		if($result){
			$this->session->set_flashdata('success_message', ' Cập nhật thành công!');
			redirect('/admin/Roles/');
		}else{
			$this->session->set_flashdata('error_message', ' Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
			redirect('/admin/Roles/');
		}
	}

	// Delete
	public function delete($id){
		$result = $this->Roles_model->delete($id);
		if($result){
			redirect('/admin/Roles/');
		}
	}

	// Active
	public function active($id){
		$result = $this->Roles_model->active($id);
		if($result){
			redirect('/admin/Roles/');
		}else{
			redirect('/admin/Roles/');
		}
	}
}
