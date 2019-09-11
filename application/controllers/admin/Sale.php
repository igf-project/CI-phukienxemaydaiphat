<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Sale extends CI_controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		if ($this->session->has_userdata('LOGIN_ADMIN')==false) {
			header("location: ".base_url()."admin/login");
		}
		$this->load->model('admin/Sale_model');
		$this->load->model('admin/Sale_group_model');
		$this->load->model('admin/Product_model');
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
		$data['action'] = isset($parameters['action']) ? $parameters['action'] : 'all';

		if($data['q'] != ''){
			$where .= " AND product_code = '".$data['q']."'";
		}
		if($data['action'] != '' AND $data['action'] != 'all'){
			$where .= " AND isactive='".$data['action']."'";
		}
		/* End GET */
		/* Set Pagging */
		$limit_per_page = 25;
		$uri_segment 	= 4;
		$num_links		= 3;
		$base_url 		= base_url().'admin/Sale/index/';
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		$total_records 	= $this->Sale_model->count_all();

		if ($total_records > 0)
		{
			$data["links"] = $this->My_library->paging($total_records, $limit_per_page, $uri_segment, $num_links, $base_url);
		}
		/* End Set Pagging */
		$data["result"] = $this->Sale_model->rows($where, $order, $page, $limit_per_page);
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
		$this->load->view('admin/Sale_view/list', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Add form
	public function add(){
		$data = array();
		$data['parent'] = $this->Sale_group_model->getListCbItem();
		if ($this->session->flashdata('err_empty')) {
			$data['err_empty'] = $this->My_library->show_message('error', $this->session->flashdata('err_empty'));
		}
		
		$data['q'] = $this->input->get('q') ? addslashes($this->input->get('q')) : '';

		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/Sale_view/add', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Edit form
	public function edit($id){
		$data = array();
		$data['id'] = $id;
		$data['result'] = $this->Sale_model->getOne($id);
		$data['parent'] = $this->Sale_group_model->getListCbItem();
		if ($this->session->flashdata('err_empty')) {
			$data['err_empty'] = $this->My_library->show_message('error', $this->session->flashdata('err_empty'));
		}
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/Sale_view/edit', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Save add form
	public function do_add(){
		$code = strip_tags($this->input->post('txt_pro_code'));
		$check_isset = $this->Product_model->check_isset($code);
		if($check_isset == true){
			$product = $this->Product_model->get_info_by_pro_code($code);
			$product_id =  $product['id'];
			$catalog_id =  $product['cata_id'];

			$start_sale = time($this->input->post('txt_start_sale'));
			$end_sale = time($this->input->post('txt_end_sale'));
			$data = array(
				'product_id'		=>	$product_id,
				'product_code'		=>	$code,
				'catalog_id'		=>	$catalog_id,
				'start_time'		=>	$start_sale,
				'end_time'			=>	$end_sale,
				'sale_group_id'		=>	addslashes($this->input->post('cbo_par')),
				'isactive'			=>	(int)$this->input->post('optactive')
			);
			$result = $this->Sale_model->add_new($data);

			if($result){
				$this->session->set_flashdata('success_message', 'Thêm mới thành công!');
				redirect('/admin/Sale/');
			}else{
				$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
				redirect('/admin/Sale/');
			}
		}else{
			$this->session->set_flashdata('err_empty', 'Không tồn tại sản phẩm với mã code vừa nhập!');
			redirect('/admin/Sale/add');
		}
	}

	// Save edit form
	public function do_edit(){
		$code = strip_tags($this->input->post('txt_pro_code'));
		$check_isset = $this->Product_model->check_isset($code);
		if($check_isset == true){
			$id = (int)$this->input->post('txtid');
			$product = $this->Product_model->get_info_by_pro_code($code);
			$product_id =  $product['id'];
			$catalog_id =  $product['cata_id'];
			$start_sale = time($this->input->post('txt_start_sale'));
			$end_sale = time($this->input->post('txt_end_sale'));
			$data = array(
				'product_id'		=>	$product_id,
				'product_code'		=>	$code,
				'catalog_id'		=>	$catalog_id,
				'start_time'		=>	$start_sale,
				'end_time'			=>	$end_sale,
				'sale_group_id'		=>	addslashes($this->input->post('cbo_par')),
				'isactive'			=>	(int)$this->input->post('optactive')
			);
			$result = $this->Sale_model->update($id, $data);

			if($result){
				$this->session->set_flashdata('success_message', 'Cập nhật thành công!');
				redirect('/admin/Sale/');
			}else{
				$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
				redirect('/admin/Sale/');
			}
		}else{
			$this->session->set_flashdata('err_empty', 'Không tồn tại sản phẩm với mã code vừa nhập!');
			redirect('/admin/Sale/add');
		}
	}

	// Active
	public function active($id){
		$result = $this->Sale_model->active($id);
		if($result){
			redirect('/admin/Sale/');
		}else{
			redirect('/admin/Sale/');
		}
	}

	// Delete
	public function delete(){
		$id 	= $this->uri->segment(4);
		$result = $this->Sale_model->delete($id);
		if($result){
			redirect('/admin/Sale/');
		}
	}

	// Ajax order
	public function saveOrder(){
		$id 	= (int)$this->input->post('id');
		$value 	= (int)$this->input->post('value');
		$this->Sale_model->saveOrder($id, $value);
	}
}

?>