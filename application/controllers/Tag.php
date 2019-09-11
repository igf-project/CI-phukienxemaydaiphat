<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag extends CI_Controller {

	private $page_title;
	private $page_metakey;
	private $page_metadesc;

	public function __construct(){
		parent::__construct();
		$this->load->model('Config_model');
		$this->load->model('Menu_model');
		$this->load->model('Product_model');
		$this->load->model('Product_tag_model');
		$this->load->model('Catalog_model');
		$this->load->model('Tag_model');
		$this->load->model('Module_model');
		$this->load->model('Post_model');
		$this->load->library('My_library');
		$this->My_library = new My_library();
	}

	public function blog($id){
		$data = array();
		$order = array('cdate'=>'DESC');
		$where = "";

		$result = $this->Tag_model->GetFamilyTree($id);
		$data['result'] = $result;

		// Get parent catalog
		if($result['GetAncestryTag(id)']!=""){
			$data['parent_tag'] = $this->Tag_model->get_list("id IN(".$result['GetAncestryTag(id)'].")");
		}

		// Get child level 1
		$data['child_lv1'] = $this->Tag_model->getChildById($id);
		foreach ($data['child_lv1'] as $k => $v) {
			$familyTreeTag = $this->Tag_model->GetFamilyTree($v['id']);

			if($familyTreeTag['GetFamilyTreeTag(id)']!=""){
				$listProductId = $this->Product_tag_model->getArrayProductIdByListTagId($familyTreeTag['GetFamilyTreeTag(id)']);

				$Array_ProductId = array(0);
				foreach ($listProductId as $k_1 => $v_1) {
					$Array_ProductId[$k_1] = $v_1['product_id'];
				}

				$data["listProduct"] = $this->Product_model->get_product_in_array($Array_ProductId,$where, $order, 0, 9);

				// Add product in to $data['child_lv1']
				$data['child_lv1'][$k]['products'] = $data["listProduct"];
			}
		}

		$sqlpro2 = "ishot = 1 AND isactive = '1' ORDER BY cdate DESC LIMIT 0,6";
		$data['hot_products']	= 	$this->Product_model->get_list($sqlpro2);
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
		$data['tags'] 			= 	$this->Tag_model->getListTag();

		$this->load->view('web/layout/head', $data);
		$this->load->view('web/layout/header_view', $data);
		$this->load->view('web/Tag_blog_view', $data);
		$this->load->view('web/layout/footer_component_view', $data);
	}

	public function blog1($id){
		$data = array();
		$order = array('cdate'=>'DESC');
		$where = "";
		$result = $this->Tag_model->GetFamilyTree($id);
		$data['result'] = $result;

		// Get parent catalog
		if($result['GetAncestryTag(id)']!=""){
			$data['parent_tag'] = $this->Tag_model->get_list("id IN(".$result['GetAncestryTag(id)'].")");
		}
		
		// Get child catalog
		if($result['GetFamilyTreeTag(id)']!=""){
			$data['child_tag'] = $this->Tag_model->get_list("id IN(".$result['GetFamilyTreeTag(id)'].")");

			// Get product by catalog id
			$data['listProductId'] = $this->Product_tag_model->getArrayProductIdByListTagId($result['GetFamilyTreeTag(id)']);
		}

		$Array_ProductId = array(0);
		foreach ($data['listProductId'] as $k => $v) {
			$Array_ProductId[$k] = $v['product_id'];
		}

		/* Set Pagging */
		$limit_per_page = 18;
		$uri_segment 	= 2;
		$num_links		= 3;
		$base_url 		= base_url().'/'.$result['link'].'-'.$id.'.html';
		$total_rows 	= $this->Product_model->find_all($Array_ProductId);
		$page = ($this->uri->segment(2)) ? ($this->uri->segment(2) - 1) : 0;

		if ($total_rows > 0){
			$data["links"] = $this->My_library->paging($total_rows, $limit_per_page, $uri_segment, $num_links, $base_url);
		}
		/* End Set Pagging */
		$data["listProduct"] = $this->Product_model->get_product_in_array($Array_ProductId,$where, $order, $page, $limit_per_page);

		$sqlpro2 = "ishot = 1 AND isactive = '1' ORDER BY cdate DESC LIMIT 0,6";
		$data['hot_products']	= 	$this->Product_model->get_list($sqlpro2);
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
		$data['tags'] 			= 	$this->Tag_model->getListTag();

		$this->load->view('web/layout/head', $data);
		$this->load->view('web/layout/header_view', $data);
		$this->load->view('web/Tag_blog_view', $data);
		$this->load->view('web/layout/footer_component_view', $data);
	}

	public function blog2($id){
		$data = array();
		$code = trim($code);
		$order = array('cdate'=>'DESC');
		$where = "";
		$result = $this->Tag_model->GetFamilyTree($id);
		$data['result'] = $result;

		// Get parent catalog
		if($result['GetAncestryTag(id)']!=""){
			$data['parent_tag'] = $this->Tag_model->get_list("id IN(".$result['GetAncestryTag(id)'].")");
		}
		
		// Get child catalog
		if($result['GetFamilyTreeTag(id)']!=""){
			$data['child_cata'] = $this->Tag_model->get_list("id IN(".$result['GetFamilyTreeTag(id)'].")");

			// Get product by catalog id
			$data['listProductId'] = $this->Product_tag_model->getArrayProductIdByListTagId($result['GetFamilyTreeTag(id)']);
		}

		$Array_ProductId = array(0);
		foreach ($data['listProductId'] as $k => $v) {
			$Array_ProductId[$k] = $v['product_id'];
		}

		/* Set Pagging */
		$limit_per_page = 18;
		$uri_segment 	= 2;
		$num_links		= 3;
		$base_url 		= base_url().'/'.$code.'/';
		$total_rows 	= $this->Product_model->find_all($Array_ProductId);
		$page = ($this->uri->segment(2)) ? ($this->uri->segment(2) - 1) : 0;

		if ($total_rows > 0){
			$data["links"] = $this->My_library->paging($total_rows, $limit_per_page, $uri_segment, $num_links, $base_url);
		}
		/* End Set Pagging */
		$data["listProduct"] = $this->Product_model->get_product_in_array($Array_ProductId,$where, $order, $page, $limit_per_page);

		$sqlpro2 = "ishot = 1 AND isactive = '1' ORDER BY cdate DESC LIMIT 0,6";
		$data['hot_products']	= 	$this->Product_model->get_list($sqlpro2);
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

		$this->load->view('web/layout/head', $data);
		$this->load->view('web/layout/header_view', $data);
		$this->load->view('web/Tag_view', $data);
		$this->load->view('web/layout/footer_component_view', $data);
	}
}
