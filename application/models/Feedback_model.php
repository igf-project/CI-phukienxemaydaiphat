<?php
class Feedback_model extends CI_Model {
	
	public function __construct(){
        parent::__construct();
    }

    public function get_list(){
        $this->db->select('*');
        $this->db->where('isactive','1');
        $this->db->order_by('order','ASC');
        $query = $this->db->get('tbl_feedback');
        return $query->result_array();
    }
}
?>