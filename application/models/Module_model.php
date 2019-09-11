<?php
Class Module_model extends CI_Model {
	private $table;
		
	function __construct() {
		parent::__construct();
	
		$this->table = 'tbl_module';
	}

	public function get_list($strwhere=' 1=1'){
		$this->db->select('*');
		$this->db->where($strwhere);
		$query = $this->db->get($this->table);
		return $query->result_array();
	}

	// get rows
	public function rows($where=NULL, $order=NULL, $page=0, $psize=25, $par_id=0) {
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

	public function getOne($position){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('position', $position);
		$result = $this->db->get()->row_array();
		// echo $this->db->last_query();
		if($result['cata_id']!=''){
			$catalog = $this->getListCbCatalog($result['cata_id']);
			$result['catalog'] = $catalog;
		}

		if($result['cate_id']!=''){
			$post_cate = $this->getListPostByPostGroupId($result['cate_id']);
			$result['post_cate'] = $post_cate;
		}

		if($result['post_id']!=''){
			$post = $this->getRowPostById($result['post_id']);
			$result['post'] = $post;
		}

		if($result['content']!=''){
			$html = $result['content'];
			$result['html'] = $html;
		}

		return $result;
	}

	public function getListCbCategory($parentid = 0,$space = '', $trees = NULL)
	{ 
		if(!$trees) $trees = array(); 
		$result = $this->db->query("SELECT id, par_id, name FROM tbl_post_group WHERE isactive=1 AND par_id=".$parentid);
		if($result->num_rows() > 0){
			$arr = $result->result_array();
			foreach ($arr as $item) {
				$trees[] 	= 	array('id'=>$item['id'],'name'=>$space.$item['name']);  
				$trees 		= 	$this->getListCbCategory($item['id'], $space, $trees); 
			}  
		}
		return $trees; 
	}

	public function getListPostByPostGroupId($cate_id){
		$this->db->select('*');
		$this->db->where('isactive', 1);
		$this->db->where('gpost_id', $cate_id);
		$query = $this->db->get('tbl_post');
		return $query->result_array();
	}

	public function getListCbCatalog($parentid = 0,$space = '', $trees = NULL)
	{ 
		if(!$trees) $trees = array(); 
		$result = $this->db->query("SELECT id, par_id, name FROM tbl_catalog WHERE isactive=1 AND par_id=".$parentid);
		if($result->num_rows() > 0){
			$arr = $result->result_array();
			foreach ($arr as $item) {
				$trees[] 	= 	array('id'=>$item['id'],'name'=>$space.$item['name']);  
				$trees 		= 	$this->getListCbCatalog($item['id'], $space, $trees); 
			}  
		}
		return $trees; 
	}

	public function getListCbProductByCatalogId($cata_id){
		$this->db->select('*');
		$this->db->where('isactive', 1);
		$this->db->where('cata_id', $cata_id);
		$query = $this->db->get('tbl_product');
		return $query->result_array();
	}

	public function getRowPostById($id){
		$this->db->select('*');
		$this->db->where('isactive', 1);
		$query = $this->db->get('tbl_post');
		return $query->row_array();
	}
}

?>