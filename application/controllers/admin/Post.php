<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Post extends CI_controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		if ($this->session->has_userdata('LOGIN_ADMIN')==false) {
			header("location: ".base_url()."admin/login");
		}
		$this->load->model('admin/Post_model');
		$this->load->model('admin/Post_group_model');
		$this->load->library('My_library');
		$this->My_library = new My_library();
	}

	public function index() {
		$data = array();
		$where = '1=1';
		$order = NULL;

		/* GET */
		$parameters = $this->input->get();
		$data['q'] = isset($parameters['q']) ? $parameters['q'] : '';
		$data['action'] = isset($parameters['action']) ? $parameters['action'] : 'all';

		if($data['q'] != ''){
			$where .= " AND title LIKE '%".$data['q']."%'";
		}
		if($data['action'] != '' AND $data['action'] != 'all'){
			$where .= " AND isactive='".$data['action']."'";
		}
		/* End GET */
		/* Set Pagging */
		$limit_per_page = 25;
		$uri_segment 	= 4;
		$num_links		= 3;
		$base_url 		= base_url().'admin/Post/index/';
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		$total_records 	= $this->Post_model->count_all();

		if ($total_records > 0)
		{
			$data["links"] = $this->My_library->paging($total_records, $limit_per_page, $uri_segment, $num_links, $base_url);
		}
		/* End Set Pagging */
		$data["result"] = $this->Post_model->rows($where, $order, $page, $limit_per_page);
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
		$this->load->view('admin/Post_view/list', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Add form
	public function add(){
		$data = array();
		$data['parent'] = $this->Post_group_model->getListCbItem();
		$data['post_related'] = $this->Post_model->getListCbRelateContent();
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/Post_view/add', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Edit form
	public function edit($id){
		$data = array();
		$data['id'] = $id;
		$data['result'] = $this->Post_model->getOne($id);
		$data['parent'] = $this->Post_group_model->getListCbItem();
		$data['post_related'] = $this->Post_model->getListCbRelateContent();
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/Post_view/edit', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	public function do_upload($filename, $path=''){
		if (!empty($_FILES[$filename]['name'])) {
			if($path !=''){
				$config['upload_path']          = $path;
			}else{
				$config['upload_path']          = './assets/uploads/post/';
			}
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 150;
			$config['max_width']            = 1600;
			$config['max_height']           = 1000;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload($filename, $path=''))
			{
				$error = array('error' => $this->upload->display_errors());

				$this->load->view('admin/layout/header_view');
				$this->load->view('admin/layout/menu_header_view');
				$this->load->view('admin/layout/asside_leftmenu_view');
				$this->load->view('admin/Post_view/add', $error);
				$this->load->view('admin/layout/right_footer_view');
				$this->load->view('admin/layout/footer_view');
				return 'ERROR';
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				return 'assets/uploads/post/'.$data['upload_data']['file_name'];
			}
		}
	}

	// Save add form
	public function do_add(){
		$img = $this->do_upload("fileImg");
		if($img != 'ERROR'){
			$post_related = json_encode($this->input->post('txt_relateContent'));
			$code = generateSeoURL($this->input->post('txt_name'));
			$data = array(
				'title'			=>	addslashes($this->input->post('txt_name')),
				'gpost_id'		=>	addslashes($this->input->post('cbo_par')),
				'intro'			=>	addslashes($this->input->post('txt_intro')),
				'fulltext'		=>	addslashes($this->input->post('txt_fulltext')),
				'meta_title'	=>	addslashes($this->input->post('txt_metatitle')),
				'meta_key'		=>	addslashes($this->input->post('txt_metakey')),
				'meta_desc'		=>	addslashes($this->input->post('txt_metadesc')),
				'related_id'	=>	$post_related,
				'code'			=>	$code,
				'thumb'			=>	$img,
				'isactive'		=>	(int)$this->input->post('optactive')
			);
			$result = $this->Post_model->add_new($data);

			if($result){
				$this->session->set_flashdata('success_message', 'Thêm mới thành công!');
				redirect('/admin/Post/');
			}else{
				$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
				redirect('/admin/Post/');
			}
		}
	}

	// Save edit form
	public function do_edit(){
		if(!empty($_FILES['fileImg']['name'])){
			$img = $this->do_upload("fileImg");
		}else{
			$img = $this->input->post('url_image');
		}

		if($img != 'ERROR'){
			$id = (int)$this->input->post('txtid');
			$post_related = json_encode($this->input->post('txt_relateContent'));
			$code = generateSeoURL($this->input->post('txt_name'));

			$data 	= 	array(
				'title'		=>	addslashes($this->input->post('txt_name')),
				'gpost_id'		=>	addslashes($this->input->post('cbo_par')),
				'intro'			=>	addslashes($this->input->post('txt_intro')),
				'fulltext'		=>	addslashes($this->input->post('txt_fulltext')),
				'meta_title'	=>	addslashes($this->input->post('txt_metatitle')),
				'meta_key'		=>	addslashes($this->input->post('txt_metakey')),
				'meta_desc'		=>	addslashes($this->input->post('txt_metadesc')),
				'related_id'	=>	$post_related,
				'code'			=>	$code,
				'thumb'			=>	$img,
				'isactive'		=>	(int)$this->input->post('optactive')
			);
			$result = $this->Post_model->update($id, $data);
			if($result){
				$this->session->set_flashdata('success_message', 'Cập nhật thành công!');
				redirect('/admin/Post/');
			}else{
				$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
				redirect('/admin/Post/');
			}
		}
	}

	// Active
	public function active($id){
		$result = $this->Post_model->active($id);
		if($result){
			redirect('/admin/Post/');
		}else{
			redirect('/admin/Post/');
		}
	}

	// Delete
	public function delete(){
		$id 	= $this->uri->segment(4);
		$result = $this->Post_model->delete($id);
		if($result){
			redirect('/admin/Post/');
		}
	}

	// Ajax order
	public function saveOrder(){
		$id 	= (int)$this->input->post('id');
		$value 	= (int)$this->input->post('value');
		$this->Post_model->saveOrder($id, $value);
	}
}

?>