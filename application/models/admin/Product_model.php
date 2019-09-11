<?php
Class Product_model extends CI_Model {
	private $table;

	function __construct() {
		parent::__construct();
		$this->table = 'tbl_product';
		$this->load->model('admin/Product_tag_model');
		$this->load->model('admin/Tag_model');
	}

	public function get_list($strwhere=' 1=1'){
		$this->db->select('*');
		$this->db->where($strwhere);
		$query = $this->db->get($this->table);
		return $query->result_array();
	}

	public function id_max($strwhere=' 1=1'){
		$this->db->select('MAX(id)');
		$this->db->where($strwhere);
		$query = $this->db->get($this->table);
		return $query->row_array();
	}

	public function check_isset($code){
		$result = $this->db->where('pro_code', $code)->get($this->table);
		if($result->num_rows()>0){
			return true;
		}
		return false;
	}
	// get rows
	public function rows($where=NULL, $order=NULL, $page=0, $psize=25) {
		$this->db->select('*');
		
		$start = $page * $psize;
		$this->db->limit($psize, $start);

		if (!empty($where)) {
			$this->db->where($where);
		}

		if (is_array($order)) {
			foreach ($order as $key=>$value) {
				$this->db->order_by($key, $value);
			}
		}
		$result = $this->db->get($this->table)->result_array();

		// Add catalog to array
		$count = count($result);
		for ($i=0;$i < $count; $i++) {
			$catalog = $this->get_name_catalog($result[$i]['cata_id']);
			$result[$i]['catalog'] = $catalog;
		}

		// Check saled
		for ($i=0;$i < $count; $i++) {
			$is_sale = $this->check_sale($result[$i]['id']);
			$result[$i]['is_sale'] = $is_sale;
		}

		return $result;
	}

	// Get name post_group
	public function get_name_catalog($id){
		$this->db->select('name');
		$this->db->where('id', $id);
		$query = $this->db->get('tbl_catalog')->row_array();
		return $query['name'];
	}

	// Check saled
	public function check_sale($id){
		$this->db->select('id');
		$this->db->where('product_id', $id);
		$query = $this->db->get('tbl_sale')->row_array();
		return $query['id'];
	}

	// Lấy tổng số record
	public function count_all($where=null) {
		$count = 0;
		if (is_null($where)) {
			$count = $this->db->from($this->table)->count_all_results();            
		} else {
			$count = $this->db->where($where)->from($this->table)->count_all_results();            
		}
		return $count;
	}

	public function getOne($id){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function get_info_by_pro_code($pro_code){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('pro_code', $pro_code);
		$query = $this->db->get()->row_array();
		return $query;
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

	// Insert
	public function add_new($data, $array_cataId){
		$this->db->trans_begin();
		$result = $this->db->insert($this->table, $data);
		$insert_id = $this->db->insert_id();

		foreach ($array_cataId as $item) {
			$arr = array(
				"product_id" => $insert_id,
				"tag_id" => $item,
			);
			$result2 = $this->Product_tag_model->add_new($arr);
		}

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
	}

	// Update
	public function update($id,$data){
		$this->db->trans_begin();
		$this->db->where('id', $id);
		$result = $this->db->update($this->table, $data);

		// Delete all record with product_id = $id
		$this->Product_tag_model->delete_by_productId($id);

		// Insert array catalog ID
		$new_arrayTagId = json_decode($data['tag_id']);
		foreach ($new_arrayTagId as $item) {
			$arr = array(
				"product_id" => $id,
				"tag_id" => $item,
			);
			$result2 = $this->Product_tag_model->add_new($arr);
		}

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
	}

	// Active
	public function active($id){
		$result = $this->db->query("UPDATE $this->table SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$id')");
		if($result){
			return true;
		}else{
			return false;
		}
	}

	// isHot
	public function ishot($id){
		$result = $this->db->query("UPDATE $this->table SET `ishot`=if(`ishot`=1,0,1) WHERE `id` in ('$id')");
		if($result){
			return true;
		}else{
			return false;
		}
	}

	// Delete
	public function delete($id){
		$this->db->trans_begin();
		// Delete in product table
		$this->db->delete($this->table, array('id' => $id));

		// Delete in product_cata table
		$this->Product_tag_model->delete_by_productId($id);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
	}

	public function saveOrder($id, $value){
		$this->db->query("UPDATE $this->table SET `order`=".$value." WHERE `id`=".$id);
	}

	public function checkCode($code){
		$condition = "pro_code =" . "'" . $code . "'";
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return 1;
		} else {
			return 0;
		}
	}
}

?>
