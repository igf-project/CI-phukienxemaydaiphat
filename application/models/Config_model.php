<?php
class Config_model extends CI_Model {

    private $table;
        
    function __construct() {
        parent::__construct();
        $this->table = 'tbl_config';
    }
    
    public function get_list(){
        $data   = array();
        $this->db->select('*');
        $query = $this->db->get($this->table);
        return $query->row_array();
    }
}
?>