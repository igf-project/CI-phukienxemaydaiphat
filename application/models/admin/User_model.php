<?php
Class User_model extends CI_Model {
	private $table;
	function __construct() {
		parent::__construct();
		$this->table = 'tbl_user';
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
		$count = count($rows);
        for ($i=0;$i < $count; $i++) {
            $query_mark = $this->db->query("SELECT name FROM tbl_user_group WHERE id='" . $rows[$i]['guser_id'] . "'");
            $rows[$i]['guser'] = $query_mark->result_array();
        } 
        
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

	// getlist by id
	public function getOneRowById($id){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}

	// Insert registration data in database
	public function registration_insert($data) {

		// Query to check whether username already exist or not
		$condition = "username =" . "'" . $data['username'] . "'";
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			// Query to insert data in database
			$this->db->insert($this->table, $data);
			if ($this->db->affected_rows() > 0) {
				return true;
			}
		} else {
			return false;
		}
	}

	// Read data using username and password
	public function login($data) {
		$condition = "username =" . "'" . $data['username'] . "' AND " . "password =" . "'" . $data['password'] . "'";
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	// Read data from database to show data in admin page
	public function read_user_information($username) {

		$condition = "username =" . "'" . $username . "'";
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return 1;
		} else {
			return 0;
		}
	}

	// Change pass
	public function changePass($id, $data) {
		$result = $this->db->update($this->table, $data, "id =".$id);
		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	// Insert into tbl_user
	public function add_new($data){
		$result = $this->db->insert($this->table, $data);
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

	// Active user
	public function active($id){
		$result = $this->db->query("UPDATE $this->table SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$id')");
		// echo $this->db->last_query();
		if($result){
			return true;
		}else{
			return false;
		}
	}

	// Delete user
	public function delete($id){
		$result = $this->db->delete($this->table, array('id' => $id));
		if($result){
			return true;
		}else{
			return false;
		}
	}
}

?>