<?php
class Product_model extends CI_Model {
    private $table;
    public function __construct() {
        parent::__construct();
        $this->table = 'tbl_product';
    }
    
    public function get_list($strwhere=' 1=1'){
        $this->db->select('*');
        $this->db->where($strwhere);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    public function id_max($strwhere=' 1=1'){
        $this->db->select('MAX(id)');
        $this->db->where($strwhere);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    public function check_isset($code){
        $result = $this->db->where('pro_code', $code)->get($this->table);
        if($result->num_rows()>0){
            return true;
        }
        return false;
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
        // Add catalog to array
        $count = count($result);
        for ($i=0;$i < $count; $i++) {
            $catalog = $this->get_name_catalog($result[$i]['cata_id']);
            $result[$i]['catalog'] = $catalog;
        }

        return $result;
    }

    // Dùng trong trường hợp $this->db->where_in(); 
    public function get_product_in_array($arrayId = NULL ,$where=NULL, $order=NULL, $page=0, $psize=25) {
        $this->db->select('*');
        
        $start = $page * $psize;
        $this->db->limit($psize, $start);

        if (!empty($where)) {
            $this->db->where($where);
        }

        if (!empty($arrayId)) {
            $this->db->where_in("id", $arrayId);
        }

        if (is_array($order)) {
            foreach ($order as $key=>$value) {
                $this->db->order_by($key, $value);
            }
        }
        $result = $this->db->get($this->table)->result_array();
        // Add catalog to array
        $count = count($result);
        for ($i=0;$i < $count; $i++) {
            $catalog = $this->get_name_catalog($result[$i]['cata_id']);
            $result[$i]['catalog'] = $catalog;
        }

        return $result;
    }

    // Get name post_group
    public function get_name_catalog($id){
        $this->db->select('name');
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_catalog')->row_array();
        return $query['name'];
    }

    // Check saled
    public function check_sale($id){
        $this->db->select('id');
        $this->db->where('product_id', $id);
        $query = $this->db->get('tbl_sale')->row_array();
        return $query['id'];
    }

    // Lấy tổng số record
    public function find_all($array = array()) {
        $result = 0;
        if(!empty($array)){
            $this->db->where_in("cata_id", $array);
            $result = $this->db->get($this->table)->num_rows();
            return $result;
        }
        return 0;
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

    public function getOne($where = NULL){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('isactive', 1);
        if($where != NULL){
            $this->db->where($where);
        }
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_info_by_pro_code($pro_code){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('pro_code', $pro_code);
        $query = $this->db->get()->row_array();
        return $query;
    }

    public function getListCbItem($parentid = 0,$space = '', $trees = NULL)
    { 
        if(!$trees) $trees = array(); 
        $result = $this->db->query("SELECT id, par_id, name FROM $this->table WHERE isactive=1 AND par_id=".$parentid);
        if($result->num_rows() > 0){
            $arr = $result->result_array();
            foreach ($arr as $item) {
                $trees[]    =   array('id'=>$item['id'],'name'=>$space.$item['name']);  
                $trees      =   $this->getListCbItem($item['id'], $space.'|---', $trees); 
            }  
        }
        return $trees; 
    }
}
?>