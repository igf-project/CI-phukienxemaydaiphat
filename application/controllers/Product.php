<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

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
		$this->load->library('My_library');
		$this->My_library = new My_library();
		$this->load->model('Product_tag_model');
		$this->load->model('Module_model');
		$this->load->model('Post_model');
	}

	public function detail($code){
		$data = array();
		$code = trim($code);
		$data['result']	= $this->Product_model->getOne("code ='".$code."'");

		// Get related tag
		$array_tagId = $this->Product_tag_model->getArrayTagIdByProductId($data['result']['id']);

		if(!empty($array_tagId)){
			foreach ($array_tagId as $k => $v) {
				$array_new_tagId[$k] = $v['tag_id'];
			}
			$data['related_tag'] = $this->Tag_model->get_list_where_id_in_array($array_new_tagId);
		}

		$data['group_product']	=	$this->Catalog_model->getOne("id ='".$data['result']['cata_id']."'");
		$data['product_same_group']=	$this->Product_model->get_list("cata_id=".$data['result']['cata_id']." AND id <> '".$data['result']['id']."' LIMIT 0,5");
		
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

		$this->load->view('web/layout/head', $data);
		$this->load->view('web/layout/header_view', $data);
		$this->load->view('web/Product_view', $data);
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

	public function new_product(){
		$data = array();
		$order = array('cdate'=>'DESC');
		$where = null;

		/* Set Pagging */
		$limit_per_page = 18;
		$uri_segment 	= 2;
		$num_links		= 3;
		$base_url 		= base_url().'san-pham-moi/';
		$total_rows 	= $this->Product_model->count_all($where);
		$page = ($this->uri->segment(2)) ? ($this->uri->segment(2) - 1) : 0;

		if ($total_rows > 0){
			$data["links"] = $this->My_library->paging($total_rows, $limit_per_page, $uri_segment, $num_links, $base_url);
		}
		/* End Set Pagging */
		$data["listProduct"] = $this->Product_model->rows($where, $order, $page, $limit_per_page);

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
		$this->load->view('web/New_product_view.php', $data);
		$this->load->view('web/layout/footer_component_view', $data);
	}

}
