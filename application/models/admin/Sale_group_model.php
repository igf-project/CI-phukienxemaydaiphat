<?php
Class Sale_group_model extends CI_Model {
	private $table;

	function __construct() {
		parent::__construct();

		$this->table = 'tbl_sale_group';
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
		// echo $this->db->last_query();
		$count = count($result);
		for ($i=0;$i < $count; $i++) {
			$query_mark = $this->db->query("SELECT * FROM $this->table WHERE par_id='" . $result[$i]['id'] . "'");
			$result[$i]['child'] = $query_mark->result_array();

			$count_child = count($result[$i]['child']);
			if($count_child>0){
				for($j=0; $j< $count_child; $j++){
					$query_mark1 = $this->db->query("SELECT * FROM $this->table WHERE par_id='" . $result[$i]['child'][$j]['id'] . "'");
					$result[$i]['child'][$j]['child1'] = $query_mark1->result_array();
				}
			}
		}
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

	public function getOne($id){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id', $id);
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

	// Insert
	public function add_new($data){
		$result = $this->db->insert($this->table, $data);
		if($result){
			return true;
		}else{
			return false;
		}
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

	public function saveOrder($id, $value){
		$this->db->query("UPDATE $this->table SET `order`=".$value." WHERE `id`=".$id);
	}
}

?>