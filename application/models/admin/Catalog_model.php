<?php
Class Catalog_model extends CI_Model {
	private $table;

	function __construct() {
		parent::__construct();

		$this->table = 'tbl_catalog';
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
				$trees 		= 	$this->getListCbItem($item['id'], $space.'|-----', $trees); 
			}  
		}
		return $trees; 
	}

	// Insert
	public function add_new($data){
		$result = $this->db->insert($this->table, $data);
		if($result){
			return $this->db->insert_id();
		}else{
			return 0;
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

	public function get_last_insert_id(){
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function getListCb(){
		$this->db->select('id, name');
		$this->db->where('isactive', 1);
		$this->db->order_by('name', 'asc');
		$result = $this->db->get($this->table);
		return $result->result_array();
	}

	public function arrayChild($id){
		$arrayName = array();
		$this->db->select('id');
		$this->db->where('par_id', $id);
		$result = $this->db->get($this->table)->result_array();
		
		foreach ($result as $k1 => $child1) {
			array_push($arrayName, $child1['id']);
		}
		return $arrayName;
	}

	public function update_array_child($id, $data){
		if($data == "[]") $data = "";
		$this->db->set('list_child', $data);
		$this->db->where('id', $id);
		$result = $this->db->update($this->table);
		if($result){
			return true;
		}else{
			return false;
		}
	}

	public function get_all_child_from_parent($par_id){
		// Cách 1
		// $sql = "SELECT  id, name, par_id
		// FROM 
		// (select * from tbl_catalog order by par_id, id) tbl_catalog,
		// (select @pv := '1') initialisation
		// where   find_in_set(par_id, @pv) > 0
		// and     @pv := concat(@pv, ',', id)";

		// Cách 2
		// $sql = "SELECT * FROM ".$this->table." AS T1 INNER JOIN 
		// (SELECT id FROM ".$this->table." WHERE par_id = ".$par_id.") AS T2 
		// ON T2.id = T1.par_id OR T1.par_id = ".$par_id." GROUP BY T1.id";

		// Cách 3
		$sql = "SELECT * FROM ".$this->table." WHERE par_id = ".$par_id."
		UNION
		SELECT * FROM ".$this->table." WHERE par_id IN 
		(SELECT ID FROM ".$this->table." WHERE par_id = ".$par_id.")";
		$result = $this->db->query($sql)->result_array();
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

	public function update_list_child($id, $list_child){
		$this->db->set('list_child', $list_child);
		$this->db->where('id', $id);
		$result = $this->db->update($this->table);
		if($result){
			return true;
		}else{
			return false;
		}
	}

	public function update_list_parent($id, $list_child){
		$this->db->set('list_parent', $list_child);
		$this->db->where('id', $id);
		$result = $this->db->update($this->table);
		if($result){
			return true;
		}else{
			return false;
		}
	}

}

?>
