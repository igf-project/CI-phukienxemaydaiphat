<?php
class Home_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }
    
    public function get_slide(){
        $data   = array();
        $this->db->select('*');
        $this->db->where('isactive','1');
        $this->db->order_by('order','ASC');
        $query = $this->db->get('tbl_slider');
        return $query->result_array();
    }

    public function update_subscribe($email){
        $data   =   array(
            'email' => $email,
            'cdate' => date('Y-m-d H:i:s', time())
        );

        if($email!= ''){
            $this->db->insert('tbl_register_email', $data);
            $data['register_email'] = 1;
        }else{
            $data['register_email'] = 0;
        }
        return $data['register_email'];
    }
}
?>