<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Product extends CI_controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		if ($this->session->has_userdata('LOGIN_ADMIN')==false) {
			header("location: ".base_url()."admin/login");
		}
		$this->load->helper('string');
		$this->load->model('admin/Product_model');
		$this->load->model('admin/Catalog_model');
		$this->load->model('admin/Product_tag_model');
		$this->load->model('admin/Tag_model');
		$this->load->library('My_library');
		$this->My_library = new My_library();
	}

	public function index() {
		$data = array();
		$where = '1=1';
		$order = array('cdate' => 'DESC');

		/* GET */
		$parameters = $this->input->get();
		$data['q'] = isset($parameters['q']) ? $parameters['q'] : '';
		$data['cata'] = isset($parameters['cata']) ? $parameters['cata'] : '';
		$data['action'] = isset($parameters['action']) ? $parameters['action'] : 'all';

		if($data['q'] != ''){
			$where .= " AND name LIKE '%".$data['q']."%'";
		}
		if($data['cata'] != ''){
			$where .= " AND cata_id = '".$data['cata']."'";
		}
		if($data['action'] != '' AND $data['action'] != 'all'){
			$where .= " AND isactive='".$data['action']."'";
		}
		/* End GET */
		/* Set Pagging */
		$limit_per_page = 25;
		$uri_segment 	= 4;
		$num_links		= 3;
		$base_url 		= base_url().'admin/Product/index/';
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		$total_records 	= $this->Product_model->count_all($where);

		if ($total_records > 0)
		{
			$data["links"] = $this->My_library->paging($total_records, $limit_per_page, $uri_segment, $num_links, $base_url);
		}
		/* End Set Pagging */
		$data["result"] = $this->Product_model->rows($where, $order, $page, $limit_per_page);
		$data["catalog"] = $this->Catalog_model->getListCbItem();
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
		$this->load->view('admin/Product_view/list', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Add form
	public function add(){
		$data = array();
		$data['parent'] = $this->Catalog_model->getListCbItem();
		$data['tags'] 	= $this->Tag_model->getListCbItem();
		$data['id_max'] = $this->Product_model->id_max();
		if ($this->session->flashdata('error_message')) {
			$data['error_message'] = $this->My_library->show_message('error', $this->session->flashdata('error_message'));
		}
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/Product_view/add', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Edit form
	public function edit($id){
		$data = array();
		$data['id'] = $id;
		$data['result'] = $this->Product_model->getOne($id);
		$data['parent'] = $this->Catalog_model->getListCbItem();
		$data['tags'] = $this->Tag_model->getListCbItem();
		$data['array_tagId'] = $this->Product_tag_model->getArrayTagIdByProductId($id);
		if ($this->session->flashdata('error_message')) {
			$data['error_message'] = $this->My_library->show_message('error', $this->session->flashdata('error_message'));
		}
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/Product_view/edit', $data);
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
				$this->load->view('admin/Product_view/add', $error);
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
			$array_tag = $this->input->post('cbo_tag');
			$json_tagId = json_encode($this->input->post('cbo_tag'));

			$cata_id = (int)$this->input->post('cbo_par');
			$code = generateSeoURL($this->input->post('txt_name'));
			$pro_code = trim($this->input->post('txt_pro_code'));
			$images = json_encode($this->input->post('file_image'));

			$data = array(
				'pro_code'		=>	addslashes($pro_code),
				'cata_id'		=>	$cata_id,
				'code'			=>	$code,
				'name'			=>	addslashes($this->input->post('txt_name')),
				'thumb'			=>	$img,
				'images'		=>	$images,
				'intro'			=>	$this->input->post('txt_intro'),
				'fulltext'		=>	$this->input->post('txt_fulltext'),
				'start_price'	=>	$this->input->post('txt_price'),
				'quantity'		=>	$this->input->post('txt_quantity'),
				'meta_title'	=>	addslashes($this->input->post('txt_metatitle')),
				'meta_key'		=>	addslashes($this->input->post('txt_metakey')),
				'meta_desc'		=>	addslashes($this->input->post('txt_metadesc')),
				'tag_id'		=>	$json_tagId,
				'isactive'		=>	(int)$this->input->post('optactive')
			);
			$result = $this->Product_model->add_new($data, $array_tag);

			if($result){
				$this->session->set_flashdata('success_message', 'Thêm mới thành công!');
				redirect('/admin/Product/');
			}else{
				$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
				redirect('/admin/Product/');
			}
		}else{
			$this->session->set_flashdata('error_message','Ảnh vượt quá kích thước cho phép!');
			redirect('/admin/Product/add');
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
			$array_tag = $this->input->post('cbo_tag');
			$json_tagId = json_encode($this->input->post('cbo_tag'));

			$cata_id = (int)$this->input->post('cbo_par');
			$code = generateSeoURL($this->input->post('txt_name'));
			$pro_code = trim($this->input->post('txt_pro_code'));
			$images = json_encode($this->input->post('file_image'));

			$data = array(
				'pro_code'		=>	addslashes($pro_code),
				'cata_id'		=>	$json_cataId,
				'code'			=>	$code,
				'name'			=>	addslashes($this->input->post('txt_name')),
				'thumb'			=>	$img,
				'images'		=>	$images,
				'intro'			=>	$this->input->post('txt_intro'),
				'fulltext'		=>	$this->input->post('txt_fulltext'),
				'start_price'	=>	$this->input->post('txt_price'),
				'quantity'		=>	$this->input->post('txt_quantity'),
				'meta_title'	=>	addslashes($this->input->post('txt_metatitle')),
				'meta_key'		=>	addslashes($this->input->post('txt_metakey')),
				'meta_desc'		=>	addslashes($this->input->post('txt_metadesc')),
				'tag_id'		=>	$json_tagId,
				'isactive'		=>	(int)$this->input->post('optactive')
			);

			$result = $this->Product_model->update($id, $data);

			// Show notification
			if($result){
				$this->session->set_flashdata('success_message', 'Cập nhật thành công!');
				redirect('/admin/Product/');
			}else{
				$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
				redirect('/admin/Product/');
			}
		}else{
			$this->session->set_flashdata('error_message', 'Ảnh vượt quá kích thước cho phép!');
			redirect('/admin/Product/edit');
		}
	}

	// isHot
	public function ishot($id){
		$result = $this->Product_model->ishot($id);
		if($result){
			redirect('/admin/Product/');
		}else{
			redirect('/admin/Product/');
		}
	}

	// Active
	public function active($id){
		$result = $this->Product_model->active($id);
		if($result){
			redirect('/admin/Product/');
		}else{
			redirect('/admin/Product/');
		}
	}

	// Delete
	public function delete($id){
		$id = $id;
		$result = $this->Product_model->delete($id);
		if($result){
			redirect('/admin/Product/');
		}
	}

	// Ajax order
	public function saveOrder(){
		$id 	= (int)$this->input->post('id');
		$value 	= (int)$this->input->post('value');
		$this->Product_model->saveOrder($id, $value);
	}

	public function checkCode(){
		$result = 0;
		if($this->input->post('proCode')){
			$proCode = trim($this->input->post('proCode'));
			$result = $this->Product_model->checkCode($proCode);
		}
		echo $result;
	}
}

?>
