<?php
Class Menu_model extends CI_Model {
    private $table;

    function __construct() {
        parent::__construct();

        $this->table = 'tbl_menu';
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

        if (isset($par_id)) {
            $this->db->where('par_id', $par_id);
        }

        $this->db->order_by('order', 'ASC');

        $result = $this->db->get($this->table)->result_array();

        $count = count($result);
        for ($i=0;$i < $count; $i++) {
            $result[$i]['url'] = $this->genarateUrl($result[$i]['view_type'], $result[$i]['cata_id'], $result[$i]['post_group_id'], $result[$i]['post_id'], $result[$i]['link']);

            $query_mark = $this->db->query("SELECT * FROM $this->table WHERE par_id='" . $result[$i]['id'] . "'");
            $result[$i]['child'] = $query_mark->result_array();

            $listChild = $result[$i]['child'];
            $count_child = count($result[$i]['child']);

            if($count_child > 0){
                foreach ($listChild as $key => $value) {
                    $result[$i]['child'][$key]['url'] = $this->genarateUrl($result[$i]['child'][$key]['view_type'], $result[$i]['child'][$key]['cata_id'], $result[$i]['child'][$key]['post_group_id'], $result[$i]['child'][$key]['post_id'], $result[$i]['child'][$key]['link']);
                }
            }
        }
        return $result;
    }

    public function genarateUrl($view_type=NULL,$cata_id=NULL,$post_group_id=NULL,$post=NULL,$link=NULL){
        $url = NULL;
        if($view_type == 'link'){
            $url = $link;
        }else if($view_type == 'catalog'){
            $catalog = $this->getCatalogById($cata_id);
            $url = base_url().$catalog['code'];
        }
        else if($view_type == 'category'){
            $category = $this->getGroupPostById($post_group_id);
            $url = base_url().'tin-tuc/'.$category['code'];
        }
        else if($view_type == 'post'){
            $post = $this->getPostById($post);
            $url = base_url().'tin-tuc/'.$post['code'].'.html';
        }
        return $url;
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

    public function getListCbItem($parentid = 0,$space = '', $trees = NULL){
        if(!$trees) $trees = array(); 
        $result = $this->db->query("SELECT id, par_id, title FROM $this->table WHERE isactive=1 AND par_id=".$parentid);
        if($result->num_rows() > 0){
            $arr = $result->result_array();
            foreach ($arr as $item) {
                $trees[]    =   array('id'=>$item['id'],'title'=>$space.$item['title']);  
                $trees      =   $this->getListCbItem($item['id'], $space.'|---', $trees); 
            }  
        }
        return $trees; 
    }

    public function getListCatalog(){
        $this->db->select('*');
        $this->db->where('isactive', 1);
        $query = $this->db->get('tbl_catalog');
        $result = $query->result_array();
        $count = count($result);

        for ($i=0;$i < $count; $i++) {
            $child = $this->getChildById('tbl_catalog', $result[$i]['id']);
            $url = base_url().'san-pham/'.$result[$i]['code'];
            $result[$i]['url'] = $url;
            $result[$i]['child'] = $child;

            $query_mark = $this->db->query("SELECT * FROM 'tbl_product' WHERE cata_id='" . $result[$i]['id'] . "'");
            $result[$i]['product'] = $query_mark->result_array();
        }
        return $result;
    }

    public function getChildById($table = NULL, $id = NULL){
        $this->db->select('*');
        $this->db->where('par_id = '.$id.' AND isactive = 1');
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function getCatalogById($id){
        $this->db->select('id, name, code');
        $this->db->where('isactive', 1);
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_catalog');
        return $query->row_array();
    }

    public function getGroupPostById($id){
        $this->db->select('id, name, code');
        $this->db->where('isactive', 1);
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_post_group');
        // echo $this->db->last_query();
        return $query->row_array();
    }

    public function getPostById($id){
        $this->db->select('id, title, code');
        $this->db->where('isactive', 1);
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_post');
        return $query->row_array();
    }
}

?>