<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Menu extends CI_controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		if ($this->session->has_userdata('LOGIN_ADMIN')==false) {
			header("location: ".base_url()."admin/login");
		}
		$this->load->model('admin/Menu_model');
		$this->load->library('My_library');
		$this->My_library = new My_library();
		$this->load->helper('text');
	}

	public function index() {
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
				$where .= " AND name LIKE '%".$data['q']."%'";
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
		$base_url 		= base_url().'admin/Menu/index/';
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		$total_records 	= $this->Menu_model->count_all('par_id = 0');

		if ($total_records > 0)
		{
			$data["links"] = $this->My_library->paging($total_records, $limit_per_page, $uri_segment, $num_links, $base_url);
		}
		/* End Set Pagging */
		$data["result"] = $this->Menu_model->rows($where, $order, $page, $limit_per_page,$par_id);
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
		$this->load->view('admin/Menu_view/list', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Add form
	public function add(){
		$data = array();
		$data['parent'] = $this->Menu_model->getListCbItem();
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/Menu_view/add', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Edit form
	public function edit($id){
		$data = array();
		$data['id'] = $id;
		$data['parent'] = $this->Menu_model->getListCbItem();
		$data['result'] = $this->Menu_model->getOne($id);
		$data['catalog'] = $this->Menu_model->getListCbCatalog();
		$data['category'] = $this->Menu_model->getListCbCategory();
		$data['post'] = $this->Menu_model->getListCbPost();
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/Menu_view/edit', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Save add form
	public function do_add(){
		$code = generateSeoURL($this->input->post('txt_name'));
		$data = array(
			'code'			=>	$code,
			'title'			=>	addslashes($this->input->post('txt_name')),
			'par_id'		=>	(int)$this->input->post('cbo_par'),
			'view_type'		=>	addslashes($this->input->post('cbo_viewtype')),
			'cata_id'		=>	(int)$this->input->post('cbo_catalog'),
			'post_group_id'	=>	(int)$this->input->post('cbo_category'),
			'post_id'		=>	(int)$this->input->post('cbo_post'),
			'link'			=>	addslashes($this->input->post('txt_url')),
			'class'			=>	addslashes($this->input->post('txt_class')),
			'icon'			=>	addslashes($this->input->post('txt_icon')),
			'isactive'		=>	(int)$this->input->post('optactive')
		);
		$result = $this->Menu_model->add_new($data);
		
		if($result){
			$this->session->set_flashdata('success_message', 'Thêm mới thành công!');
			redirect('/admin/Menu/');
		}else{
			$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
			redirect('/admin/Menu/');
		}
	}

	// Save edit form
	public function do_edit(){
		$id = (int)$this->input->post('txtid');
		$code = generateSeoURL($this->input->post('txt_name'));
		$data = array(
			'code'			=>	$code,
			'title'			=>	addslashes($this->input->post('txt_name')),
			'par_id'		=>	addslashes($this->input->post('cbo_par')),
			'view_type'		=>	$this->input->post('cbo_viewtype'),
			'cata_id'		=>	(int)$this->input->post('cbo_catalog'),
			'post_group_id'	=>	(int)$this->input->post('cbo_category'),
			'post_id'		=>	(int)$this->input->post('cbo_post'),
			'link'			=>	addslashes($this->input->post('txt_url')),
			'class'			=>	addslashes($this->input->post('txt_class')),
			'icon'			=>	$this->input->post('txt_icon'),
			'isactive'		=>	(int)$this->input->post('optactive')
		);
		$result = $this->Menu_model->update($id, $data);
		if($result){
			$this->session->set_flashdata('success_message', 'Cập nhật thành công!');
			redirect('/admin/Menu/');
		}else{
			$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
			redirect('/admin/Menu/');
		}
	}

	// Active
	public function active($id){
		$result = $this->Menu_model->active($id);
		if($result){
			redirect('/admin/Menu/');
		}else{
			redirect('/admin/Menu/');
		}
	}

	// Delete
	public function delete(){
		$id 	= $this->uri->segment(4);
		$result = $this->Menu_model->delete($id);
		if($result){
			redirect('/admin/Menu/');
		}
	}

	// Ajax order
	public function saveOrder(){
		$id 	= (int)$this->input->post('id');
		$value 	= (int)$this->input->post('value');
		$this->Menu_model->saveOrder($id, $value);
	}

	public function check_view_type(){
		$data = array();
		$view_type = $this->input->post('view_type');
		if($view_type == 'link'){
			$str='<label>Url</label><font color="red">*</font>';
			$str.='<input type="text" name="txt_url" class="form-control" placeholder="Url" required>';
		}else if($view_type == 'catalog'){
			$data['catalog'] = $this->Menu_model->getListCbCatalog();
			$str= '<label>Nhóm sản phẩm</label><font color="red">*</font>';
			$str.='<select name="cbo_catalog" id="cbo_catalog" class="form-control">';
			$str.='<option value="0" title="Top">Chọn một nhóm sản phẩm</option>';
			foreach ($data['catalog'] as $item) {
				$str.='<option value="'.$item['id'].'">'.$item['name'].'</option>';
			}
			$str.='</select>';
			$str.='<script>$("#cbo_catalog").select2();</script>';
		}else if($view_type == 'category'){
			$data['category'] = $this->Menu_model->getListCbCategory();
			$str= '<label>Nhóm bài viết</label><font color="red">*</font>';
			$str.='<select name="cbo_category" id="cbo_category" class="form-control">';
			$str.='<option value="0" title="Top">Chọn một nhóm bài viết</option>';
			foreach ($data['category'] as $item) {
				$str.='<option value="'.$item['id'].'">'.$item['name'].'</option>';
			}
			$str.='</select>';
			$str.='<script>$("#cbo_category").select2();</script>';
		}else if($view_type == 'post'){
			$str = $this->Menu_model->getListCbPost();
			$data['post'] = $this->Menu_model->getListCbPost();
			$str= '<label>Bài viết</label><font color="red">*</font>';
			$str.='<select name="cbo_post" id="cbo_post" class="form-control">';
			$str.='<option value="0" title="Top">Chọn một bài viết</option>';
			foreach ($data['post'] as $item) {
				$str.='<option value="'.$item['id'].'">'.$item['title'].'</option>';
			}
			$str.='</select>';
			$str.='<script>$("#cbo_post").select2();</script>';
		}else{
			$str='<label>Url</label><font color="red">*</font>';
			$str.='<input type="text" name="txt_url" class="form-control" placeholder="Url" required>';
		}
		echo $str;
	}
}

?>