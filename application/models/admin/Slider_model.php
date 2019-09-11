<?php
Class Slider_model extends CI_Model {
	private $table;
		
	function __construct() {
		parent::__construct();
	
		$this->table = 'tbl_slider';
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

	public function getOne($id){
		$this->db->select('*');
		$this->db->from('tbl_slider');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

	// Insert
	public function add_new($data){
		$result = $this->db->insert('tbl_slider', $data);
		if($result){
			return true;
		}else{
			return false;
		}
	}

	// Update
	public function update($id,$data){
		$this->db->where('id',$id);
		$result = $this->db->update('tbl_slider', $data);
		if($result){
			return true;
		}else{
			return false;
		}
	}

	// Active
	public function active($id){
		$result = $this->db->query("UPDATE `tbl_slider` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$id')");
		if($result){
			return true;
		}else{
			return false;
		}
	}

	// Delete
	public function delete($id){
		$result = $this->db->delete('tbl_slider', array('id' => $id));
		if($result){
			return true;
		}else{
			return false;
		}
	}

	public function saveOrder($id, $value){
		$this->db->query("UPDATE `tbl_slider` SET `order`=".$value." WHERE `id`=".$id);
	}
}

?>