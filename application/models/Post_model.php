<?php
Class Post_model extends CI_Model {
	private $table;

	function __construct() {
		parent::__construct();

		$this->table = 'tbl_post';
	}

	public function get_list($strwhere=' 1=1', $page=NULL, $psize=NULL){
		$this->db->select('*');
		$this->db->where($strwhere);
		
		$start = $page * $psize;
		$this->db->limit($psize, $start);

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

		// Add post_group_name to array
		$count = count($result);
		for ($i=0;$i < $count; $i++) {
			$post_group_name = $this->get_name_post_group($result[$i]['gpost_id']);
			$result[$i]['post_group'] = $post_group_name;
		} 
		return $result;
	}

	// Get name post_group
	public function get_name_post_group($id){
		$this->db->select('name');
		$this->db->where('id', $id);
		$query = $this->db->get('tbl_post_group')->row_array();
		return $query['name'];
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

	public function getOne($where=NULL){
		$this->db->select('*');
		$this->db->from($this->table);
		if (!empty($where)) {
			$this->db->where($where);
		}
		$result = $this->db->get()->row_array();

		$category = $this->getCategory($result['gpost_id']);
		$result['category'] = $category;
		$post_related = $this->getListRelate(json_decode($result['related_id']));
		$result['related'] = $post_related;
		return $result;
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

	public function getListRelate($array=NULL){
		if(count($array)>0){
			$this->db->select('*');
			$this->db->where('isactive', 1);
			$this->db->where_in('id', $array);
			$this->db->order_by('cdate', 'DESC');
			$result = $this->db->get($this->table);
			return $result->result_array();
		}else{
			return;
		}
	}

	public function getCategory($category_id){
		$this->db->select('*');
		$this->db->where('isactive', 1);
		$this->db->where('id', $category_id);
		$result = $this->db->get('tbl_post_group');
		return $result->row_array();
	}
}

?>