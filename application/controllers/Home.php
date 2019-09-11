<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Config_model');
		$this->load->model('Home_model');
		$this->load->model('Menu_model');
		$this->load->model('Catalog_model');
		$this->load->model('Product_model');
		$this->load->model('Tag_model');
		$this->load->model('Product_tag_model');
		$this->load->model('Module_model');
		$this->load->model('Post_model');
	}

	public function index()
	{
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
		$data['tags'] 			= 	$this->Tag_model->getListTag();
		$data['slider']			= 	$this->Home_model->get_slide();
		
		// Get list products
		$sqlpro1 = "isactive = '1' ORDER BY cdate DESC LIMIT 0,35";
		$sqlpro2 = "ishot = 1 AND isactive = '1' ORDER BY cdate DESC LIMIT 0,6";
		
		$data['hot_products']	= 	$this->Product_model->get_list($sqlpro2);
		$data['products']		= 	$this->Product_model->get_list($sqlpro1);
		$data['root_cata']		=	$this->Catalog_model->get_list('par_id = 0');
		
		// Module
		$data['module1']		=	$this->Module_model->getOne('box1');
		$data['module2']		=	$this->Module_model->getOne('box2');

		$sql1 = 'gpost_id ='.$data['module1']['cate_id'];
		$sql2 = 'gpost_id ='.$data['module2']['cate_id'];

		$data['box1']	=	$this->Post_model->get_list($sql1, 0, 6);
		$data['box2']	=	$this->Post_model->get_list($sql2, 0, 6);
		$data['box3']	=	$this->Module_model->getOne('box3');
		$data['box4']	=	$this->Module_model->getOne('box4');
		// End module

		$this->load->view('web/layout/head', $data);
		$this->load->view('web/layout/header_view', $data);
		$this->load->view('web/layout/navbar_view', $data);
		$this->load->view('web/home_view', $data);
		$this->load->view('web/layout/footer_view', $data);
	}

	public function subscribe(){
		$this->load->view('web/layout/header_view');
		$email 	= isset($_POST['register_email']) ? $_POST['register_email'] : '';
		if($email!=''){
			$data['register_email'] = $this->Home_model->update_subscribe($email);
			// if($result){
			
			// }
		}
		$this->load->view('web/layout/footer_view');
	}
}
