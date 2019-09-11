<?php
Class Catalog_model extends CI_Model {
	private $table;

	function __construct() {
		parent::__construct();

		$this->table = 'tbl_catalog';
		$this->load->model('Product_model');
		$this->load->model('Tag_model');
	}

	public function get_list($strwhere=' 1=1'){
		$this->db->select('*');
		$this->db->where($strwhere);
		$query = $this->db->get($this->table);
		return $query->result_array();
	}

	// get rows
	public function rows($where=NULL, $order=NULL, $page=0, $psize=25, $par_id=NULL) {
		$this->db->select('*');
		
		$start = $page * $psize;
		$this->db->limit($psize, $start);

		if (!empty($where)) {
			$this->db->where($where);
		}

		if (isset($par_id)) {
			$this->db->where('par_id', $par_id);
		}

		if (is_array($order)) {
			foreach ($order as $key=>$value) {
				$this->db->order_by($key, $value);
			}
		}

		$result = $this->db->get($this->table)->result_array();
		
		$count = count($result);
		for ($i=0;$i < $count; $i++) {

			$id_child0 = $result[$i]['child'][$j]['id'];
			$result[$i]['child'] = $this->getListChildById($id_child0);

			$count_child = count($result[$i]['child']);
			if($count_child>0){
				for($j=0; $j< $count_child; $j++){

					$id_child1 = $result[$i]['child'][$j]['id'];
					$result[$i]['child'][$j]['child1'] = $this->getListChildById($id_child1);
				}
			}
		}
		return $result;
	}

	public function getListChildById($id){
		// $this->db->select('id, par_id, alias, name, code, image, order, url');
		$this->db->select('*');
		$this->db->where('par_id', $id);
		$result = $this->db->get($this->table)->result_array();
		return $result;
	}

	// Lấy tổng số record
	public function count_all($where=null) {
		$count = 0;
		if (!isset($where)) {
			$count = $this->db->from($this->table)->count_all_results();            
		} else {
			$count = $this->db->where($where)->from($this->table)->count_all_results();            
		}
		return $count;
	}

	public function getOne($where = NULL){
		$this->db->select('*');
		$this->db->from($this->table);
		if($where != NULL){
			$this->db->where($where);
		}
		$query = $this->db->get();
		return $query->row_array();
	}

	public function getListCbItem($parentid = 0,$space = '', $trees = NULL)
	{ 
		if(!$trees) $trees = array(); 
		$result = $this->db->query("SELECT id, par_id, name FROM $this->table WHERE isactive=1 AND par_id=".$parentid);
		if($result->num_rows() > 0){
			$arr = $result->result_array();
			foreach ($arr as $item) {
				$trees[] 	= 	array('id'=>$item['id'],'name'=>$space.$item['name']);  
				$trees 		= 	$this->getListCbItem($item['id'], $space.'|---', $trees); 
			}  
		}
		return $trees; 
	}

	public function getListCatalog(){
		$this->db->select('*');
		$this->db->where('isactive', 1);
		$this->db->where('par_id', 0);
		$query = $this->db->get($this->table);
		$result = $query->result_array();
		$count = count($result);

		for ($i=0;$i < $count; $i++) {
			$child = $this->getChildById($result[$i]['id']);
			$url = base_url().$result[$i]['code'];
			$result[$i]['url'] = $url;
			$result[$i]['child'] = $child;
			$count_child = count($child);

			for ($j=0; $j < $count_child; $j++) { 
				$child2 = $this->getChildById($child[$j]['id']);
				$jurl = base_url().$child[$j]['code'];
				$result[$i]['child'][$j]['url'] = $jurl;
				$result[$i]['child'][$j]['child2'] = $child2;
				$count_child2 = count($child2);

				for ($k=0; $k < $count_child2; $k++) { 
					$kurl = base_url().$child2[$k]['code'];
					$result[$i]['child'][$j]['child2'][$k]['url'] = $kurl;
				}
			}
		}
		return $result;
	}

	public function getChildById($id = NULL){
		$this->db->select('*');
		$this->db->order_by('order', 'ASC');
		$this->db->where('par_id = '.$id.' AND isactive = 1');
		$query = $this->db->get($this->table);
		return $query->result_array();
	}

	// Sử dụng STORE PROCEDURE
	// Lấy ID cha trực tiếp của ID truyền vào
	public function GetParentIDByID($id){
		$sql = "SELECT id,par_id,GetParentIDByID(id) FROM ".$this->table." WHERE id = ". $id;
		$result = $this->db->query($sql)->result_array();
		return $result;
	}

	// Lấy danh sách tất cả các ID cha của ID truyền vào
	public function GetAncestry($id){
		$sql = "SELECT id,par_id,GetAncestry(id) FROM ".$this->table." WHERE id = ". $id;
		$result = $this->db->query($sql)->row_array();
		return $result;
	}

	// Lấy danh sách tất cả các ID con của ID truyền vào
	public function GetFamilyTree($id){
		$sql = "SELECT id,par_id,GetParentIDByID(id),GetAncestry(id),GetFamilyTree(id) FROM ".$this->table." WHERE id = ". $id;
		$result = $this->db->query($sql)->row_array();
		return $result;
	}

	// Lấy danh sách tất cả các ID con của ID truyền vào
	public function GetFamilyTreeByCode($code){
		$sql = "SELECT *,GetParentIDByID(id),GetAncestry(id),GetFamilyTree(id) FROM ".$this->table." WHERE code = '".$code."'";
		$result = $this->db->query($sql)->row_array();
		return $result;
	}
}

?>