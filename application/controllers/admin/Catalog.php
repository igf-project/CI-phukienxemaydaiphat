<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Catalog extends CI_controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		if ($this->session->has_userdata('LOGIN_ADMIN')==false) {
			header("location: ".base_url()."admin/login");
		}
		$this->load->model('admin/Catalog_model');
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
		$base_url 		= base_url().'admin/Catalog/index/';
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		$total_records 	= $this->Catalog_model->count_all('par_id = 0');

		if ($total_records > 0)
		{
			$data["links"] = $this->My_library->paging($total_records, $limit_per_page, $uri_segment, $num_links, $base_url);
		}
		/* End Set Pagging */
		$data["result"] = $this->Catalog_model->rows($where, $order, $page, $limit_per_page,$par_id);
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
		$this->load->view('admin/Catalog_view/list', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Add form
	public function add(){
		$data = array();
		$data['parent'] = $this->Catalog_model->getListCbItem();
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/Catalog_view/add', $data);
		$this->load->view('admin/layout/right_footer_view');
		$this->load->view('admin/layout/footer_view');
	}

	// Edit form
	public function edit($id){
		$data = array();
		$data['id'] = $id;
		$data['parent'] = $this->Catalog_model->getListCbItem();
		$data['result'] = $this->Catalog_model->getOne($id);
		$this->load->view('admin/layout/header_view');
		$this->load->view('admin/layout/menu_header_view');
		$this->load->view('admin/layout/asside_leftmenu_view');
		$this->load->view('admin/Catalog_view/edit', $data);
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
				$this->load->view('admin/Catalog_view/add', $error);
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
			$code = generateSeoURL($this->input->post('txt_name'));
			$par_id = (int)$this->input->post('cbo_par');
			$data = array(
				'name'			=>	addslashes($this->input->post('txt_name')),
				'alias'			=>	addslashes($this->input->post('txt_alias')),
				'par_id'		=>	$par_id,
				'intro'			=>	addslashes($this->input->post('txt_intro')),
				'meta_title'	=>	addslashes($this->input->post('txt_metatitle')),
				'meta_key'		=>	addslashes($this->input->post('txt_metakey')),
				'meta_desc'		=>	addslashes($this->input->post('txt_metadesc')),
				'code'			=>	$code,
				'image'			=>	$img,
				'isactive'		=>	(int)$this->input->post('optactive')
			);
			$result = $this->Catalog_model->add_new($data);

			if($result != 0){
				// Find all parent id
				$list_parID = $this->Catalog_model->GetAncestry($result);

				// Update list_parent
				$this->Catalog_model->update_list_parent($result, $list_parID['GetAncestry(id)']);

				if($list_parID['GetAncestry(id)'] != ''){
					// Convert to array
					$arr_parID = explode(",", $list_parID['GetAncestry(id)']);

					// Loop array parent id get list FamilyTree of each item
					// Update table with list FamilyTree
					foreach ($arr_parID as $key => $value) {
						$FamilyTree = $this->Catalog_model->GetFamilyTree($value);
						$ids = $FamilyTree['GetFamilyTree(id)'];
						$this->Catalog_model->update_list_child($value, $ids);
					}
				}

				$this->session->set_flashdata('success_message', 'Thêm mới thành công!');
				redirect('/admin/Catalog/');
			}else{
				$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
				redirect('/admin/Catalog/');
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
			$parentOld = (int)$this->input->post('parentOld');
			$code = generateSeoURL($this->input->post('txt_name'));

			// Find all parent id
			$list_old_parID = $this->Catalog_model->GetAncestry($id);

			// Convert to array
			$arr_old_parID = explode(",", $list_old_parID['GetAncestry(id)']);

			$data 	= 	array(
				'name'			=>	addslashes($this->input->post('txt_name')),
				'alias'			=>	addslashes($this->input->post('txt_alias')),
				'par_id'		=>	addslashes($this->input->post('cbo_par')),
				'intro'			=>	addslashes($this->input->post('txt_intro')),
				'meta_title'	=>	addslashes($this->input->post('txt_metatitle')),
				'meta_key'		=>	addslashes($this->input->post('txt_metakey')),
				'meta_desc'		=>	addslashes($this->input->post('txt_metadesc')),
				'code'			=>	$code,
				'image'			=>	$img,
				'isactive'		=>	(int)$this->input->post('optactive')
			);
			$result = $this->Catalog_model->update($id, $data);
			if($result){
				$list_new_parID = $this->Catalog_model->GetAncestry($id);
				// Update list_parent
				$this->Catalog_model->update_list_parent($id, $list_new_parID['GetAncestry(id)']);
				/* Update list_child cho những parent trước khi bị thay đổi */
				if($list_old_parID['GetAncestry(id)'] != 0){
					// Loop array old parent id get list FamilyTree of each item
					// Update table with list FamilyTree
					foreach ($arr_old_parID as $key => $value) {
						$FamilyTree = $this->Catalog_model->GetFamilyTree($value);
						$ids = $FamilyTree['GetFamilyTree(id)'];
						$this->Catalog_model->update_list_child($value, $ids);
					}
				}

				/* Update list_child cho những parent sau khi bị thay đổi */

				// Find all parent id
				$list_parID = $this->Catalog_model->GetAncestry($id);

				if($list_parID['GetAncestry(id)'] ! = ''){
					// Convert to array
					$arr_parID = explode(",", $list_parID['GetAncestry(id)']);

					// Loop array parent id get list FamilyTree of each item
					// Update table with list FamilyTree
					foreach ($arr_parID as $key => $value) {
						$FamilyTree = $this->Catalog_model->GetFamilyTree($value);
						$ids = $FamilyTree['GetFamilyTree(id)'];
						$this->Catalog_model->update_list_child($value, $ids);
					}
				}

				$this->session->set_flashdata('success_message', 'Cập nhật thành công!');
				redirect('/admin/Catalog/');
			}else{
				$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
				redirect('/admin/Catalog/');
			}
		}
	}

	// Active
	public function active($id){
		$result = $this->Catalog_model->active($id);
		if($result){
			redirect('/admin/Catalog/');
		}else{
			redirect('/admin/Catalog/');
		}
	}

	// Delete
	public function delete(){
		$id 	= $this->uri->segment(4);
		$result = $this->Catalog_model->delete($id);
		if($result){
			redirect('/admin/Catalog/');
		}
	}

	// Ajax order
	public function saveOrder(){
		$id 	= (int)$this->input->post('id');
		$value 	= (int)$this->input->post('value');
		$this->Catalog_model->saveOrder($id, $value);
	}
}

?>