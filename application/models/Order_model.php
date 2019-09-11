<?php
Class Order_model extends CI_Model {
	private $table;

	function __construct() {
		parent::__construct();

		$this->table = 'tbl_order';
		$this->load->model('admin/Product_model');
	}

	public function get_list($strwhere=' 1=1'){
		$this->db->select('*');
		$this->db->where($strwhere);
		$query = $this->db->get($this->table);
		return $query->result_array();
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

		return $result;
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

	// Insert
	public function add_new($data){
		$this->db->trans_begin();
		$result = $this->db->insert($this->table, $data);
		$order_id = $this->db->insert_id();
		$cart = $_SESSION['CART'];
		$num = count($_SESSION['CART']);
		for ($i=0; $i < $num; $i++) { 
			$arr = array(
				"order_id" => $order_id,
				"pro_id" => $cart[$i]['id'],
				"pro_code" => $cart[$i]['pro_code'],
				"quantity" => $cart[$i]['sl'],
				"price" => $cart[$i]['start_price'],
				"status" => 1
			);
			$result2 = $this->add_new_order_detail($arr);
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

	public function add_new_order_detail($data){
		$result = $this->db->insert('tbl_order_detail', $data);
	}

	// Update
	public function update($id,$data){
		$this->db->where('id',$id);
		$result = $this->db->update($this->table, $data);
		if($result){
			return true;
		}else{
			return false;
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

	// Delete
	public function delete($id){
		$result = $this->db->delete($this->table, array('id' => $id));
		if($result){
			return true;
		}else{
			return false;
		}
	}

	public function get_product_by_order_id($order_id){
		$this->db->where('order_id', $order_id);
		$result = $this->db->get('tbl_order_detail')->result_array();
		// Add catalog to array
		$count = count($result);
		for ($i=0;$i < $count; $i++) {
			$product = $this->Product_model->getOne($result[$i]['pro_id']);
			$result[$i]['product'] = $product;
		}
		return $result;
	}
}