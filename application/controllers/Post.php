<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Controller {

	private $page_title;
	private $page_metakey;
	private $page_metadesc;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Config_model');
		$this->load->model('Menu_model');
		$this->load->model('Post_model');
		$this->load->model('Post_group_model');
		$this->load->model('Catalog_model');
		$this->load->model('Tag_model');
		$this->load->library('My_library');
		$this->My_library = new My_library();
		$this->load->model('Module_model');
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

		$order_news = array('cdate' => 'DESC');
		$data['menu']			= 	$this->Menu_model->rows();
		$data['catalog']		= 	$this->Catalog_model->getListCatalog();
		$data['tags']		= 	$this->Tag_model->getListTag();
		$data['news']			=	$this->Post_model->rows(NULL, $order_news, 0, 6);
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
		$this->load->view('web/layout/header_view');
		$this->load->view('web/home_view', $data);
		$this->load->view('web/layout/footer_component_view', $data);
	}

	public function blog($code){
		$data = array();
		$code = trim($code);
		$order = array('cdate'=>'DESC');
		$where = "code = '".$code."'";
		$result = $this->Post_group_model->getOne($where);
		$data['result'] = $result;
		/* Set Pagging */
		$limit_per_page = 12;
		$uri_segment 	= 3;
		$num_links		= 3;
		$base_url 		= base_url().'/tin-tuc/'.$code.'/';
		$page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;
		$total_records 	= $this->Post_model->count_all("gpost_id = ".$result['id']);

		if ($total_records > 0)
		{
			$data["links"] = $this->My_library->paging($total_records, $limit_per_page, $uri_segment, $num_links, $base_url);
		}
		/* End Set Pagging */
		$data["listPost"] = $this->Post_model->rows("gpost_id = ".$result['id'], $order, $page, $limit_per_page);

		$data['listHot'] 		= 	$this->Post_model->get_list("isactive = '1' ORDER BY `cdate` DESC", NULL, 6);
		$data['config'] 		= 	$this->Config_model->get_list();
		$data['page_title'] 	= 	$data['result']['name'];
		$data['page_keyword'] 	= 	$data['result']['meta_key'];
		$data['page_descript'] 	= 	$data['result']['meta_desc'];
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

		$this->load->view('web/layout/head', $data);
		$this->load->view('web/layout/header_view', $data);
		$this->load->view('web/Post_group_view', $data);
		$this->load->view('web/layout/footer_component_view', $data);
	}

	public function detail($code){
		$data = array();
		$code = trim($code);
		$data['result']			=	$this->Post_model->getOne("code ='".$code."'");
		$data['posts_same_group']=	$this->Post_model->get_list("gpost_id=".$data['result']['gpost_id'],0,4);
		$data['listHot'] 		= 	$this->Post_model->get_list("isactive = '1' ORDER BY `cdate` DESC", NULL, 6);
		$data['config'] 		= 	$this->Config_model->get_list();
		$data['page_title'] 	= 	$data['result']['title'];
		$data['page_keyword'] 	= 	$data['result']['meta_key'];
		$data['page_descript'] 	= 	$data['result']['meta_desc'];
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

		$this->load->view('web/layout/head', $data);
		$this->load->view('web/layout/header_view', $data);
		$this->load->view('web/Post_detail_view', $data);
		$this->load->view('web/layout/footer_component_view', $data);
	}
}
