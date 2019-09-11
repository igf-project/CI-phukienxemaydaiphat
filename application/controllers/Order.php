<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	private $page_title;
	private $page_metakey;
	private $page_metadesc;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Config_model');
		$this->load->model('Menu_model');
		$this->load->model('Product_model');
		$this->load->model('Catalog_model');
		$this->load->model('Tag_model');
		$this->load->model('Order_model');
		$this->load->library('My_library');
		$this->My_library = new My_library();
		$this->load->model('Module_model');
		$this->load->model('Post_model');
	}

	public function index(){
		$data = array();
		$data['config'] 		= 	$this->Config_model->get_list();
		$data['page_title'] 	= 	$data['config']['title'];
		$data['page_keyword'] 	= 	$data['config']['meta_keyword'];
		$data['page_descript'] 	= 	$data['config']['meta_descript'];
		$data['page_phone'] 	= 	$data['config']['phone'];
		$data['page_email'] 	= 	$data['config']['email'];
		$data['page_facebook'] 	= 	$data['config']['facebook'];
		$data['page_gplus'] 	= 	$data['config']['gplus'];

		$order = array('cdate' => 'DESC');
		$data['menu']			= 	$this->Menu_model->rows();
		$data['catalog']		= 	$this->Catalog_model->getListCatalog();
		$data['tags']		= 	$this->Tag_model->getListTag();

		// Module
		$data['module1']		=	$this->Module_model->getOne('box1');
		$data['module2']		=	$this->Module_model->getOne('box2');

		$sql1 = 'gpost_id ='.$data['module1']['cate_id'];
		$sql2 = 'gpost_id ='.$data['module2']['cate_id'];
		$sql3 = "ishot = 1 AND isactive = '1' ORDER BY cdate DESC LIMIT 0,6";

		$data['hot_products']	= 	$this->Product_model->get_list($sql3);
		$data['box1']	=	$this->Post_model->get_list($sql1, 0, 6);
		$data['box2']	=	$this->Post_model->get_list($sql2, 0, 6);
		$data['box3']	=	$this->Module_model->getOne('box3');
		$data['box4']	=	$this->Module_model->getOne('box4');
		// End module

		$this->load->view('web/layout/head', $data);
		$this->load->view('web/layout/header_view', $data);
		$this->load->view('web/Order_view', $data);
		$this->load->view('web/layout/footer_component_view', $data);
	}

	public function check_out(){
		$data = array();
		$data['config'] 		= 	$this->Config_model->get_list();
		$data['page_title'] 	= 	$data['config']['title'];
		$data['page_keyword'] 	= 	$data['config']['meta_keyword'];
		$data['page_descript'] 	= 	$data['config']['meta_descript'];
		$data['page_phone'] 	= 	$data['config']['phone'];
		$data['page_email'] 	= 	$data['config']['email'];
		$data['page_facebook'] 	= 	$data['config']['facebook'];
		$data['page_gplus'] 	= 	$data['config']['gplus'];

		$order = array('cdate' => 'DESC');
		$data['menu']			= 	$this->Menu_model->rows();
		$data['catalog']		= 	$this->Catalog_model->getListCatalog();
		$data['tags']			= 	$this->Tag_model->getListTag();

		// Module
		$data['module1']		=	$this->Module_model->getOne('box1');
		$data['module2']		=	$this->Module_model->getOne('box2');

		$sql1 = 'gpost_id ='.$data['module1']['cate_id'];
		$sql2 = 'gpost_id ='.$data['module2']['cate_id'];
		$sql3 = "ishot = 1 AND isactive = '1' ORDER BY cdate DESC LIMIT 0,6";

		$data['hot_products']	= 	$this->Product_model->get_list($sql3);
		$data['box1']	=	$this->Post_model->get_list($sql1, 0, 6);
		$data['box2']	=	$this->Post_model->get_list($sql2, 0, 6);
		$data['box3']	=	$this->Module_model->getOne('box3');
		$data['box4']	=	$this->Module_model->getOne('box4');
		// End module

		$this->load->view('web/layout/head', $data);
		$this->load->view('web/layout/header_view', $data);
		$this->load->view('web/Check_out_view', $data);
		$this->load->view('web/layout/footer_component_view', $data);
	}

	public function addCart(){
		// $this->session->unset_userdata('CART');die();
		$id = $this->input->post('id');
		$product_code = $this->input->post('pro_code');
		$quantity = $this->input->post('quantity');
		$data = $this->Product_model->getOne("id = ".$id);

		$item = array(
			'id' => $data['id'],
			'pro_code' => $data['pro_code'],
			'cata_id' => $data['cata_id'],
			'code' => $data['code'],
			'name' => $data['name'],
			'thumb' => $data['thumb'],
			'start_price' => $data['start_price'],
			'sl' => $quantity
		);

		if(!isset($_SESSION['CART'])) $_SESSION['CART'] = array();
		// kiem tra xem gio hang da co san pham vua them
		$n = count($_SESSION['CART']);
		$flag = false;
		if($n>0){
			for($i=0;$i<$n;$i++){
				if($_SESSION['CART'][$i]['pro_code']==$product_code){
					$_SESSION['CART'][$i]['sl'] += $quantity;
					$flag=true; break;
				}
			}
		}
		// them moi
		if($flag==false) $_SESSION['CART'][$n] = $item;
		echo count($_SESSION['CART']);
	}

	public function update_quantity(){
		$post = $this->input->post('quantity');
		$n = count($_SESSION['CART']);
		$i = 0;
		foreach ($post as $key => $value) {
			$_SESSION['CART'][$i]['sl'] = $value;
			++$i;
		}
		redirect('/gio-hang/');
	}

	public function addnew(){
		$data = array(
			'firstname'		=>	addslashes($this->input->post('txt_firstname')),
			'lastname'		=>	addslashes($this->input->post('txt_lastname')),
			'address'		=>	addslashes($this->input->post('txt_address')),
			'email'			=>	addslashes($this->input->post('txt_email')),
			'phone'			=>	addslashes($this->input->post('txt_phone')),
			'totalmoney'	=>	addslashes($this->input->post('txt_totalmoney')),
			'status'		=>	1
		);
		$result = $this->Order_model->add_new($data);

		if($result){
			$this->session->unset_userdata('CART');
			$this->session->set_flashdata('success_message', 'Đặt hàng thành công!');
			redirect('/Order/checkout_success');
		}else{
			$this->session->set_flashdata('error_message', 'Có lỗi trong quá trình xử lý. Xin vui lòng thử lại');
			redirect('/Order/checkout_success/');
		}
	}

	public function delete($id){
		$n = count($_SESSION['CART']);
		$arr = array();
		for ($i=0; $i < $n; $i++) { 
			if($_SESSION['CART'][$i]['id'] != $id){
				array_push($arr,$_SESSION['CART'][$i]);
			}
		}
		$_SESSION['CART']=$arr;
		redirect('/gio-hang/');
	}

	public function checkout_success(){
		$data = array();
		$data['config'] 		= 	$this->Config_model->get_list();
		$data['page_title'] 	= 	$data['config']['title'];
		$data['page_keyword'] 	= 	$data['config']['meta_keyword'];
		$data['page_descript'] 	= 	$data['config']['meta_descript'];
		$data['page_phone'] 	= 	$data['config']['phone'];
		$data['page_email'] 	= 	$data['config']['email'];
		$data['page_facebook'] 	= 	$data['config']['facebook'];
		$data['page_gplus'] 	= 	$data['config']['gplus'];

		$data['menu']			= 	$this->Menu_model->rows();
		$data['catalog']		= 	$this->Catalog_model->getListCatalog();
		$data['tags']			= 	$this->Tag_model->getListTag();

		// Module
		$data['module1']		=	$this->Module_model->getOne('box1');
		$data['module2']		=	$this->Module_model->getOne('box2');

		$sql1 = 'gpost_id ='.$data['module1']['cate_id'];
		$sql2 = 'gpost_id ='.$data['module2']['cate_id'];
		$sql3 = "ishot = 1 AND isactive = '1' ORDER BY cdate DESC LIMIT 0,6";

		$data['hot_products']	= 	$this->Product_model->get_list($sql3);
		$data['box1']	=	$this->Post_model->get_list($sql1, 0, 6);
		$data['box2']	=	$this->Post_model->get_list($sql2, 0, 6);
		$data['box3']	=	$this->Module_model->getOne('box3');
		$data['box4']	=	$this->Module_model->getOne('box4');
		// End module

		/* Show message */
		if ($this->session->flashdata('success_message')) {
			$data['success_message'] = $this->My_library->show_message('success', $this->session->flashdata('success_message'));
		}
		if ($this->session->flashdata('error_message')) {
			$data['error_message'] = $this->My_library->show_message('error', $this->session->flashdata('error_message'));
		}
		/* End Show message */

		$this->load->view('web/layout/head', $data);
		$this->load->view('web/layout/header_view', $data);
		$this->load->view('web/checkout_success_view', $data);
		$this->load->view('web/layout/footer_component_view', $data);
	}

}
