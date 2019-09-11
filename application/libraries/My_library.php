<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class My_library {
	protected $CI;

	// We'll use a constructor, as you can't directly call a function
	// from a property definition.
	public function __construct()
	{
		// Assign the CodeIgniter super-object
		$this->CI =& get_instance();
	}

	function paging($total_records, $limit_per_page, $uri_segment, $num_links, $base_url){
		if ($total_records > 0)
		{
			$config['base_url'] 	= $base_url;
			$config['total_rows'] 	= $total_records;
			$config['per_page'] 	= $limit_per_page;
			$config["uri_segment"] 	= $uri_segment;

            // custom paging configuration
			$config['num_links'] = $num_links;
			$config['use_page_numbers'] = TRUE;
			$config['reuse_query_string'] = TRUE;

			$config['full_tag_open'] 	= '<div class="box-paging"><ul class="pagination">';
			$config['full_tag_close'] 	= '</ul></div>';

			$config['first_link'] 		= 'First Page';
			$config['first_tag_open'] 	= '<li class="first">';
			$config['first_tag_close']	= '</li>';

			$config['last_link'] 		= 'Last Page';
			$config['last_tag_open'] 	= '<li class="last">';
			$config['last_tag_close'] 	= '</li>';

			$config['next_link'] 		= 'Next »';
			$config['next_tag_open'] 	= '<li>';
			$config['next_tag_close'] 	= '</li>';

			$config['prev_link'] 		= '« Prev';
			$config['prev_tag_open'] 	= '<li>';
			$config['prev_tag_close'] 	= '</li>';

			$config['cur_tag_open'] 	=  '<li class="currentpage active"><a href="">';
			$config['cur_tag_close'] 	=  '</a></li>';

			$config['num_tag_open'] 	=  '<li>';
			$config['num_tag_close'] 	=  '</li>';

			$this->CI->pagination->initialize($config);

            // build paging links
			return $this->CI->pagination->create_links();
		}
	}

	function show_message($message, $property){
		if($message == 'error'){
			return "<div class='alert alert-danger alert-dismissable' role='alert'>
			<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
			<strong>Warning!</strong>".$property."</div>";
		}elseif ($message == 'success') {
			return "<div class='alert alert-success alert-dismissable' role='alert'>
			<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
			<strong>Success!</strong>".$property."</div>";
		}
	}
}
?>