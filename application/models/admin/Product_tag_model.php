<?php
Class Product_tag_model extends CI_Model {
	private $table;

	function __construct() {
		parent::__construct();
		$this->table = 'tbl_product_tag';
	}

	public function getArrayTagIdByProductId($id){
		$this->db->select('tag_id');
		$this->db->where("product_id", $id);
		$result = $this->db->get($this->table)->result_array();
		return $result;
	}

	public function getArrayProductIdByCataId($id){
		$this->db->select('product_id');
		$this->db->where("tag_id", $id);
		$result = $this->db->get($this->table)->result_array();
		return $result;
	}

	// Insert 
	public function add_new($data){
		$result = $this->db->insert($this->table, $data);
	}

	// Delete all record by product_id
	public function delete_by_productId($product_id){
		$result = $this->db->delete($this->table, array('product_id' => $product_id));
		if($result){
			return true;
		}else{
			return false;
		}
	}
}
