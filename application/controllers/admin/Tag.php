<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Tag extends CI_controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		if ($this->session->has_userdata('LOGIN_ADMIN')==false) {
			header("location: ".base_url()."admin/login");
		}
		$this->load->model('admin/Tag_model');
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
		$limit_per_page = 8;
		$uri_segment 	= 4;
		$num_links		= 3;
		$base_url 		= base_url().'admin/tag/index/';
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		$total_records 	= $this->Tag_model->count_all('par_id = 0');
		
		if ($total_records > 0)
		{
			$data["links"] = $this->My_library->paging($total_records, $limit_per_page, $uri_segment, $num_links, $base_url);
		}
		/* End Set Pagging */
		$data["result"] = $this->Tag_model->rows($where, $order, $page, $limit_per_page,$par_id);
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
		$this->load->view('admin/Tag_view/list', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Add form
	public function add(){
		$data = array();
		$data['parent'] = $this->Tag_model->getListCbItem();
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/Tag_view/add', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Edit form
	public function edit($id){
		$data = array();
		$data['id'] = $id;
		$data['parent'] = $this->Tag_model->getListCbItem();
		$data['result'] = $this->Tag_model->getOne($id);
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/Tag_view/edit', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Save add form
	public function do_add(){
		$code = generateSeoURL($this->input->post('txt_name'));
		$par_id = (int)$this->input->post('cbo_par');
		$data = array(
			'par_id'		=>	$par_id,
			'name'			=>	addslashes($this->input->post('txt_name')),
			'code'			=>	$code,
			'link'			=>	addslashes($this->input->post('txt_link')),
			'meta_title'	=>	addslashes($this->input->post('txt_metatitle')),
			'meta_key'		=>	addslashes($this->input->post('txt_metakey')),
			'meta_desc'		=>	addslashes($this->input->post('txt_metadesc')),
			'isactive'		=>	(int)$this->input->post('optactive')
		);
		$result = $this->Tag_model->add_new($data);

		if($result){
			// Find all parent id
			$list_parID = $this->Tag_model->GetAncestry($result);

			// Update list_parent
			$this->Tag_model->update_list_parent($result, $list_parID['GetAncestryTag(id)']);

			if($list_parID['GetAncestryTag(id)'] != ''){
				// Convert to array
				$arr_parID = explode(",", $list_parID['GetAncestryTag(id)']);
				// Loop array parent id get list FamilyTree of each item
				// Update table with list FamilyTree
				foreach ($arr_parID as $k => $v) {
					$FamilyTree = $this->Tag_model->GetFamilyTree($v);
					$ids = $FamilyTree['GetFamilyTreeTag(id)'];
					$this->Tag_model->update_list_child($v, $ids);
				}
			}
			
			$this->session->set_flashdata('success_message', 'Thêm mới thành công!');
			redirect('/admin/tag/');
		}else{
			// $this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
			// redirect('/admin/tag/');
		}
	}

	// Save edit form
	public function do_edit(){
		$id = (int)$this->input->post('txtid');
		$code = generateSeoURL($this->input->post('txt_name'));
		$par_id = (int)$this->input->post('cbo_par');

		// Find all parent id
		$list_old_parID = $this->Tag_model->GetAncestry($id);

		// Convert to array
		$arr_old_parID = explode(",", $list_old_parID['GetAncestryTag(id)']);

		$data = array(
			'par_id'		=>	$par_id,
			'name'			=>	addslashes($this->input->post('txt_name')),
			'code'			=>	$code,
			'link'			=>	addslashes($this->input->post('txt_link')),
			'meta_title'	=>	addslashes($this->input->post('txt_metatitle')),
			'meta_key'		=>	addslashes($this->input->post('txt_metakey')),
			'meta_desc'		=>	addslashes($this->input->post('txt_metadesc')),
			'isactive'		=>	(int)$this->input->post('optactive')
		);
		$result = $this->Tag_model->update($id, $data);
		if($result){
			$list_new_parID = $this->Tag_model->GetAncestry($id);

			// Update list_parent
			$this->Tag_model->update_list_parent($id, $list_new_parID['GetAncestryTag(id)']);
			
			/* Update list_child cho những parent trước khi bị thay đổi */

			// Loop array old parent id get list FamilyTree of each item
	
			if($list_old_parID['GetAncestryTag(id)'] != ''){
				foreach ($arr_old_parID as $k => $v) {
					$FamilyTree = $this->Tag_model->GetFamilyTree($v);
					$ids = $FamilyTree['GetFamilyTreeTag(id)'];
					$this->Tag_model->update_list_child($v, $ids);
				}
			}
			
			/* Update list_child cho những parent sau khi bị thay đổi */

			// Find all parent id
			$list_FamilyTree = $this->Tag_model->GetFamilyTree($id);

			if($list_FamilyTree['GetAncestryTag(id)'] != ''){
				// Convert to array
				$arr_parID 	= explode(",", $list_FamilyTree['GetAncestryTag(id)']);
				
				// Loop array parent id get list FamilyTree of each item
				// Update table with list FamilyTree
				foreach ($arr_parID as $k => $v) {
					$FamilyTree = $this->Tag_model->GetFamilyTree($v);
					$ids = $FamilyTree['GetFamilyTreeTag(id)'];
					$this->Tag_model->update_list_child($v, $ids);
				}
			}

			// Update list_child for itself
			$childID = $list_FamilyTree['GetFamilyTreeTag(id)'];
			$this->Tag_model->update_list_child($id, $childID);

			$this->session->set_flashdata('success_message', 'Cập nhật thành công!');
			redirect('/admin/tag/');
		}else{
			$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
			redirect('/admin/tag/');
		}
	}

	// Active
	public function active($id){
		$result = $this->Tag_model->active($id);
		if($result){
			redirect('/admin/tag/');
		}else{
			redirect('/admin/tag/');
		}
	}

	// Delete
	public function delete($id){
		$result = $this->Tag_model->delete($id);
		if($result){
			redirect('/admin/tag/');
		}
	}

	// Ajax order
	public function saveOrder(){
		$id 	= (int)$this->input->post('id');
		$value 	= (int)$this->input->post('value');
		$this->Tag_model->saveOrder($id, $value);
	}
}

?>