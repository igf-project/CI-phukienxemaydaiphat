<?php
Class Config_model extends CI_Model {
	private $table;
		
	function __construct() {
		parent::__construct();
		$this->table = 'tbl_config';
	}

	public function get_list($strwhere=' 1=1'){
		$this->db->select('*');
		$this->db->where($strwhere);
		$query = $this->db->get($this->table);
		return $query->row_array();
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
		
		$rows = $this->db->get($this->table)->result_array();
		
		return $rows;
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

	// Update
	public function update($id, $data){
		$this->db->where('id',$id);
		$result = $this->db->update($this->table, $data);
		if($result){
			return true;
		}else{
			return false;
		}
	}
}

?>