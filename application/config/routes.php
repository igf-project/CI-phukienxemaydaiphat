<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['admin'] 						= 'admin/Home';
$route['admin/logout'] 					= 'admin/Users/logout';


$route['trang-chu'] 				= 'Home';
$route['san-pham-moi'] 				= 'Product/new_product';
$route['san-pham-moi/(:num)'] 		= 'Product/new_product';
$route['tim-kiem?(:any)'] 			= 'Search';
$route['tim-kiem/(:num)?(:any)'] 	= 'Search';
$route['gio-hang'] 					= 'Order';
$route['thanh-toan'] 				= 'Order/check_out';

$route['lien-he'] 					= 'Contact';
$route['lien-he/submit_contact'] 	= 'Contact/submit_contact';

$route['tin-tuc/(:any).html'] 		= 'Post/detail/$1';
$route['tin-tuc/(:any)'] 			= 'Post/blog/$1';
$route['tin-tuc/(:any)/(:num)'] 	= 'Post/blog/$1';

$route['san-pham-(:any)-(:num).html'] 				= 'Tag/blog/$2';
$route['san-pham-(:any)-(:num).html/(:num)'] 		= 'Tag/blog/$2';

$route['phu-tung-(:any)-(:num).html'] 				= 'Tag/blog2/$2';
$route['phu-tung-(:any)-(:num).html/(:num)'] 		= 'Tag/blog2/$2';

$route['do-choi-(:any)-(:num).html'] 				= 'Tag/blog2/$2';
$route['do-choi-(:any)-(:num).html/(:num)'] 		= 'Tag/blog2/$2';

$route['(:any).html'] 				= 'Product/detail/$1';
$route['(:any)/(:num)'] 			= 'Catalog/blog/$1';
$route['(:any)'] 					= 'Catalog/blog/$1';
