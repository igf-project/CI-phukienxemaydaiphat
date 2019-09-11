<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Users extends CI_controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		if ($this->session->has_userdata('LOGIN_ADMIN')==false) {
			header("location: ".base_url()."admin/login");
		}
		$this->load->model('admin/User_model');
		$this->load->model('admin/Guser_model');
		$this->load->model('admin/Roles_model');
		$this->load->library('My_library');
		$this->My_library = new My_library();
	}

	// Show login page
	public function index() {
		$data = array();
		$where = '1=1';
		$order = NULL;

		/* GET */
		$parameters = $this->input->get();
		$data['q'] = isset($parameters['q']) ? $parameters['q'] : '';
		$data['action'] = isset($parameters['action']) ? $parameters['action'] : 'all';
		
		if($data['q'] != ''){
			$where .= " AND firstname LIKE '%".$data['q']."%' OR lastname LIKE '%".$data['q']."%'";
		}
		if($data['action'] != '' AND $data['action'] != 'all'){
			$where .= " AND isactive='".$data['action']."'";
		}
		/* End GET */
		/* Set Pagging */
		$limit_per_page = 25;
		$uri_segment 	= 3;
		$num_links		= 3;
		$base_url 		= base_url().'admin/Users/';
		$page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;
		$total_records 	= $this->User_model->count_all();

		if ($total_records > 0)
		{
			$data["links"] = $this->My_library->paging($total_records, $limit_per_page, $uri_segment, $num_links, $base_url);
		}
		/* End Set Pagging */

		$data["users"] = $this->User_model->rows($where, $order, $page, $limit_per_page);

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
		$this->load->view('admin/user_view/list', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Show registration page
	public function user_registration_show() {
		$this->load->view('admin/user_view/registration_form');
	}

	// Check for user login process
	public function user_login_process() {
		$data = array(
			'username' => $this->input->post('username'),
			'password' => md5(sha1(trim($this->input->post('password'))))
		);

		$result = $this->User_model->login($data);
		if ($result == TRUE) {
			$username = $this->input->post('username');
			$result = $this->User_model->read_user_information($username);
			if ($result != false) {

				$session_data = array(
					'USER_NAME' => $result[0]->username,
					'FIRST_NAME' => $result[0]->firstname,
					'LAST_NAME' => $result[0]->lastname,
					'GROUP_ID' => $result[0]->guser_id,
					'PHONE' => $result[0]->phone,
					'AVATAR' => $result[0]->avatar
				);
				// Add user data in session
				$this->session->set_userdata('LOGIN_ADMIN', $session_data);
				header("location: ".base_url()."admin/Home");
			}
		} else {
			$data = array(
				'error_message' => 'Invalid Username or Password'
			);
			$this->load->view('admin/user_view/login_form',$data);
		}
	}

	// Login from admin page
	public function login() {
		$this->load->view('admin/user_view/login_form');
	}

	// Logout from admin page
	public function logout() {
		$sess_array = array(
			'USER_NAME' => '',
			'FIRST_NAME' => '',
			'LAST_NAME' => '',
			'GROUP_ID' => '',
			'PHONE' => '',
			'AVATAR' => ''
		);
		$this->session->unset_userdata('LOGIN_ADMIN', $sess_array);
		$data['message_display'] = 'Successfully Logout';
		$this->load->view('admin/user_view/login_form',$data);
	}


	// Changepass form
	public function changepass($id){
		$data 	= 	array();
		// Show message
		if ($this->session->flashdata('success_message')) {
			$data['success_message'] = $this->My_library->show_message('success', $this->session->flashdata('success_message'));
		}
		if ($this->session->flashdata('error_message')) {
			$data['error_message'] = $this->My_library->show_message('error', $this->session->flashdata('error_message'));
		}
		$data['row_user'] = $this->User_model->getOneRowById($id);
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/user_view/changepass_form',$data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Changepass
	public function do_changepass(){
		$id = $this->input->post('txtid');
		$password =	md5(sha1(trim($this->input->post('txtpassword'))));
		$data = array(
			'password'	=> 	$password
		);
		$result = $this->User_model->changePass($id, $data);
		if($result){
			$this->session->set_flashdata('success_message', 'Đổi mật khẩu thành công!');
			redirect('/admin/users/changepass/'.$id);
		}else{
			$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
			redirect('/admin/users/changepass/'.$id);
		}
	}

	// Add form
	public function add(){
		$data = array();
		// $data['list_guser'] = $this->Guser_model->getListCbItem();
		$data['roles'] = $this->Roles_model->get_checkbox();
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/user_view/add',$data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Save add form
	public function do_add(){
		$birthday	=	date('Y-m-d',strtotime($this->input->post('txtbirthday')));
		$password	=	md5(sha1(trim($this->input->post('txtpassword'))));
		$roles = json_encode($this->input->post('_roles'));
		$data = array(
			'username'		=>	addslashes($this->input->post('txtusername')),
			'firstname'		=>	addslashes($this->input->post('txtfirstname')),
			'lastname'		=>	addslashes($this->input->post('txtlastname')),
			'birthday'		=>	$birthday,
			'gender'		=>	addslashes($this->input->post('optgender')),
			'address'		=>	addslashes($this->input->post('txtaddress')),
			'phone'			=>	addslashes($this->input->post('txtphone')),
			'email'			=>	addslashes($this->input->post('txtemail')),
			'guser_id'		=>	addslashes($this->input->post('cbo_gmember')),
			'isactive'		=>	(int)$this->input->post('optactive'),
			'password'		=> 	$password,
			'roles_id'		=> 	$roles,
			'joindate' 		=> 	time()
		);
		$result = $this->User_model->add_new($data);
		if($result){
			$this->session->set_flashdata('success_message', 'Thêm mới thành công!');
			redirect('/admin/users/');
		}else{
			$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
			redirect('/admin/users/');
		}
	}

	// Edit form
	public function edit($id){
		$data = array();
		// $data['list_guser'] = $this->Guser_model->getListCbItem();
		$data['id'] = $id;
		$data['user_data'] = $this->User_model->getOneRowById($data['id']);
		$data['roles'] = $this->Roles_model->get_checkbox();
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/user_view/edit',$data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Save edit form
	public function do_edit(){
		$birthday	=	date('Y-m-d',strtotime($this->input->post('txtbirthday')));
		$id 		=	(int)$this->input->post('txtid');
		$roles = json_encode($this->input->post('_roles'));
		$data = array(
			'firstname'		=>	addslashes($this->input->post('txtfirstname')),
			'lastname'		=>	addslashes($this->input->post('txtlastname')),
			'birthday'		=>	$birthday,
			'gender'		=>	addslashes($this->input->post('optgender')),
			'address'		=>	addslashes($this->input->post('txtaddress')),
			'phone'			=>	addslashes($this->input->post('txtphone')),
			'email'			=>	addslashes($this->input->post('txtemail')),
			'guser_id'		=>	addslashes($this->input->post('cbo_gmember')),
			'roles_id'		=> 	$roles,
			'isactive'		=>	(int)$this->input->post('optactive')
		);
		$result = $this->User_model->update($id, $data);
		if($result){
			$this->session->set_flashdata('success_message', 'Cập nhật thành công!');
			redirect('/admin/users/');
		}else{
			$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
			redirect('/admin/users/');
		}
	}

	// Active
	public function active(){
		$id 	= $this->uri->segment(4);
		$result = $this->User_model->active($id);
		if($result){
			header("location: ".base_url()."admin/users");
		}
	}

	// Delete
	public function delete(){
		$id 	= $this->uri->segment(4);
		$result = $this->User_model->delete($id);
		if($result){
			header("location: ".base_url()."admin/users");
		}
	}

	// Check isset user
	public function check_user(){
		$result = 0;
		if($this->input->post('username')){
			$username = $this->input->post('username');
			$result = $this->User_model->read_user_information($username);
		}
		echo $result;
	}
}

?>