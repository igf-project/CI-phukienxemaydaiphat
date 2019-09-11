<?php
Class Sale_model extends CI_Model {
	private $table;
		
	function __construct() {
		parent::__construct();
		$this->table = 'tbl_sale';
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

		// Add sale_group to array
		$count = count($result);
        for ($i=0;$i < $count; $i++) {
        	$sale_group = $this->get_name_sale_group($result[$i]['sale_group_id']);
            $result[$i]['sale_group'] = $sale_group;
        } 

        // Add product to array
		$count = count($result);
        for ($i=0;$i < $count; $i++) {
        	$product_name = $this->get_name_product($result[$i]['product_id']);
            $result[$i]['product_name'] = $product_name;
        } 

		return $result;
	}

	// Get name post_group
	public function get_name_sale_group($id){
		$this->db->select('name');
		$this->db->where('id', $id);
		$result = $this->db->get('tbl_sale_group')->row_array();
		return $result['name'];
	}

	// Get name product
	public function get_name_product($id){
		$this->db->select('name');
		$this->db->where('id', $id);
		$result = $this->db->get('tbl_product')->row_array();
		return $result['name'];
	}

	// Get all product
	public function get_all_product(){
		$this->db->select('name, id');
		$this->db->where('isactive', 1);
		$result = $this->db->get('tbl_product')->result_array();
		// echo $this->db->last_query();
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
		echo $this->db->last_query();
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