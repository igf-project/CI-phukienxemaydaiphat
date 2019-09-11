<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Module extends CI_controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		if ($this->session->has_userdata('LOGIN_ADMIN')==false) {
			header("location: ".base_url()."admin/login");
		}
		$this->load->model('admin/Module_model');
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
			$where .= " AND name LIKE '%".$data['q']."%'";
		}
		if($data['action'] != '' AND $data['action'] != 'all'){
			$where .= " AND isactive='".$data['action']."'";
		}
		/* End GET */
		/* Set Pagging */
		$limit_per_page = 25;
		$uri_segment 	= 4;
		$num_links		= 3;
		$base_url 		= base_url().'admin/Module/';
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		$total_records 	= $this->Module_model->count_all();

		if ($total_records > 0)
		{
			$data["links"] = $this->My_library->paging($total_records, $limit_per_page, $uri_segment, $num_links, $base_url);
		}
		/* End Set Pagging */
		$data["result"] = $this->Module_model->rows($where, $order, $page, $limit_per_page);
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
		$this->load->view('admin/Module_view/list', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Add form
	public function add(){
		$data = array();
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/Module_view/add', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Edit form
	public function edit($id){
		$data = array();
		$data['id'] = $id;
		$data['result'] = $this->Module_model->findById($data['id']);
		$data['catalog'] = $this->Module_model->getListCbCatalog();
		$data['category'] = $this->Module_model->getListCbCategory();
		$data['post'] = $this->Module_model->getListCbPost();
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/Module_view/edit', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}


	// Save add form
	public function do_add(){
		$data = array(
			'name'			=>	$this->input->post('txt_name'),
			'type'			=>	$this->input->post('cbo_viewtype'),
			'position'		=>	$this->input->post('cbo_position'),
			'class'			=>	$this->input->post('txt_class'),
			'cata_id'		=>	$this->input->post('cbo_catalog'),
			'cate_id'		=>	$this->input->post('cbo_category'),
			'post_id'		=>	$this->input->post('cbo_post'),
			'class'			=>	$this->input->post('txt_class'),
			'content'		=>	$this->input->post('txt_fulltext'),
			'isactive'		=>	(int)$this->input->post('optactive')
		);
		$result = $this->Module_model->add_new($data);
		if($result){
			$this->session->set_flashdata('success_message', 'Thêm mới thành công!');
			redirect('/admin/Module/');
		}else{
			$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
			redirect('/admin/Module/');
		}
	}

	// Save edit form
	public function do_edit(){
		$id = (int)$this->input->post('txtid');
		$data 	= 	array(
			'name'			=>	$this->input->post('txt_name'),
			'type'			=>	$this->input->post('cbo_viewtype'),
			'position'		=>	$this->input->post('cbo_position'),
			'class'			=>	$this->input->post('txt_class'),
			'cata_id'		=>	$this->input->post('cbo_catalog'),
			'cate_id'		=>	$this->input->post('cbo_category'),
			'post_id'		=>	$this->input->post('cbo_post'),
			'class'			=>	$this->input->post('txt_class'),
			'content'		=>	$this->input->post('txt_fulltext'),
			'isactive'		=>	(int)$this->input->post('optactive')
		);
		$result = $this->Module_model->update($id, $data);
		if($result){
			$this->session->set_flashdata('success_message', 'Cập nhật thành công!');
			redirect('/admin/Module/');
		}else{
			$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
			redirect('/admin/Module/');
		}
	}

	// Active
	public function active($id){
		$result = $this->Module_model->active($id);
		if($result){
			redirect('/admin/Module/');
		}else{
			redirect('/admin/Module/');
		}
	}

	// Delete
	public function delete(){
		$id 	= $this->uri->segment(4);
		$result = $this->Module_model->delete($id);
		if($result){
			redirect('/admin/Module/');
		}
	}

	// Ajax order
	public function saveOrder(){
		$id 	= (int)$this->input->post('id');
		$value 	= (int)$this->input->post('value');
		$this->Module_model->saveOrder($id, $value);
	}

	public function check_view_type($type){
		$data = array();
		$view_type = $type;
		if($view_type == 'catalog'){
			$data['catalog'] = $this->Module_model->getListCbCatalog();
			$str= '<div class="col-sm-6 form-group">';
			$str.= '<label>Nhóm sản phẩm</label><font color="red">*</font>';
			$str.='<select name="cbo_catalog" id="cbo_catalog" class="form-control">';
			$str.='<option value="0" title="Top">Chọn một nhóm sản phẩm</option>';
			foreach ($data['catalog'] as $item) {
				$str.='<option value="'.$item['id'].'">'.$item['name'].'</option>';
			}
			$str.='</select>';
			$str.='<script>$("#cbo_catalog").select2();</script>';
			$str.='</div>';
		}else if($view_type == 'category'){
			$data['category'] = $this->Module_model->getListCbCategory();
			$str= '<div class="col-sm-6 form-group">';
			$str.= '<label>Nhóm bài viết</label><font color="red">*</font>';
			$str.='<select name="cbo_category" id="cbo_category" class="form-control">';
			$str.='<option value="0" title="Top">Chọn một nhóm bài viết</option>';
			foreach ($data['category'] as $item) {
				$str.='<option value="'.$item['id'].'">'.$item['name'].'</option>';
			}
			$str.='</select>';
			$str.='<script>$("#cbo_category").select2();</script>';
			$str.='</div>';
		}else if($view_type == 'post'){
			$str = $this->Module_model->getListCbPost();
			$data['post'] = $this->Module_model->getListCbPost();
			$str= '<div class="col-sm-6 form-group">';
			$str.= '<label>Bài viết</label><font color="red">*</font>';
			$str.='<select name="cbo_post" id="cbo_post" class="form-control">';
			$str.='<option value="0" title="Top">Chọn một bài viết</option>';
			foreach ($data['post'] as $item) {
				$str.='<option value="'.$item['id'].'">'.$item['title'].'</option>';
			}
			$str.='</select>';
			$str.='<script>$("#cbo_post").select2();</script>';
			$str.='</div>';
		}else{
			$str= '<div class="col-sm-12 form-group">';
			$str.='
			<label class="control-label">Nội dung</label>
			<textarea name="txt_fulltext" id="txt_fulltext" rows="3" class="form-control" placeholder="Nội dung"/></textarea>';
			$str.='<script type="text/javascript">CKEDITOR.replace("txt_fulltext", {height : "300px"}); </script>';
			$str.='</div>';
		}
		echo $str;
	}
}

?>