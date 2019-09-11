<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_multiple extends CI_controller {
	public function __construct(){
		parent:: __construct();
		$this->load->library('session');
		if ($this->session->has_userdata('LOGIN_ADMIN')==false) {
			header("location: ".base_url()."admin/login");
		}
	}

	public function index()
	{
		$data = array();
		$this->load->view('admin/Upload_multiple');
	}

	public function upload(){
		if($_FILES["files"]['name'] != ''){
			$output = '';
			$config['upload_path']          = './assets/uploads/';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 150;
			$config['max_width']            = 1000;
			$config['max_height']           = 1000;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			for($count = 0; $count < count($_FILES["files"]['name']); $count++){
				$_FILES["file"]['name'] = $_FILES["files"]['name'][$count];
				$_FILES["file"]['type'] = $_FILES["files"]['type'][$count];
				$_FILES["file"]['tmp_name'] = $_FILES["files"]['tmp_name'][$count];
				$_FILES["file"]['error'] = $_FILES["files"]['error'][$count];
				$_FILES["file"]['size'] = $_FILES["files"]['size'][$count];

				if($this->upload->do_upload('file')){
					$data = $this->upload->data();
					$output .='
					<input type="hidden" name="file_image[]" value="assets/uploads/'.$data["file_name"].'">
					<img src="'.base_url().'assets/uploads/'.$data["file_name"].'" class="img-responsive img-thumbnail" />';
				}
			}
			echo $output;
		}
	}

	// Upload use for form add product
	public function upload1($filename){
		if($_FILES[$filename]['name'] != ''){
			$output = '';
			$config['upload_path']          = './assets/uploads/';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 150;
			$config['max_width']            = 1000;
			$config['max_height']           = 1000;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			$_FILES["file"]['name'] = $_FILES["$filename"]['name'];
			$_FILES["file"]['type'] = $_FILES["$filename"]['type'];
			$_FILES["file"]['tmp_name'] = $_FILES["$filename"]['tmp_name'];
			$_FILES["file"]['error'] = $_FILES["$filename"]['error'];
			$_FILES["file"]['size'] = $_FILES["$filename"]['size'];

			$this->my_escapeshellarg($_FILES["file"]['name']);
			if($this->upload->do_upload('file')){
				$data = $this->upload->data();
				$output .='
				<input type="hidden" name="file_image[]" value="assets/uploads/'.$data["file_name"].'">
				<img src="'.base_url().'assets/uploads/'.$data["file_name"].'" class="img-responsive img-thumbnail" />';
			}else{
				$output .='<input type="hidden" value="" class="required">';
				$output .='<div>Lỗi! kích thước ảnh lớn nhất là 1000x1000, dung lượng <=150KB</div>';
			}

			echo $output;
		}
	}

	public function my_escapeshellarg($input)
	{
		$input = str_replace('\'', '\\\'', $input);

		return '\''.$input.'\'';
	}

	// Upload use for form edit product
	public function upload_edit($filename){
		if($_FILES["$filename"]['name'] != ''){
			$output = '';
			$config['upload_path']          = './assets/uploads/';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 150;
			$config['max_width']            = 1000;
			$config['max_height']           = 1000;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			$_FILES["file"]['name'] = $_FILES["$filename"]['name'];
			$_FILES["file"]['type'] = $_FILES["$filename"]['type'];
			$_FILES["file"]['tmp_name'] = $_FILES["$filename"]['tmp_name'];
			$_FILES["file"]['error'] = $_FILES["$filename"]['error'];
			$_FILES["file"]['size'] = $_FILES["$filename"]['size'];

			if($this->upload->do_upload('file')){
				$data = $this->upload->data();
				$output .='assets/uploads/'.$data["file_name"];
			}else{
				$output .='';
			}
			echo $output;
		}
	}
}
