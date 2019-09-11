<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

function add_last_slash($path) {
    $path = trim($path);
    if (strlen($path)==0) {
        return $path;
    }
    $s1 = substr($path, strlen($path)-1);
    if ($s1 != '/') {
        $path = $path . '/';
    }
    return $path;
}

function my_base_url() {
    $CI  =& get_instance();
    $url =  $CI->config->item('base_url');
    $idx =  $CI->config->item('index_page');
    $path = add_last_slash($url) . add_last_slash($idx);
    return $path;
}

function my_root_url() {
    $CI  =& get_instance();
    $url =  $CI->config->item('base_url');
    $url =  add_last_slash($url);
    return $url;
}

function lang_path($name, $ext = 'json') {
    $CI  =& get_instance();
    $str =  $CI->config->item('language');

    $dir = APPPATH.'language\\'.$str;
    $dir =  $dir . '\\' . $str . '-' . $name . '.' . $ext; 
    return $dir;
}

function read_lang_json($name) {
	$file = lang_path($name);
	//echo '<br>'.$file;
	if (!file_exists($file)) {
		return null;
	}

	$str = file_get_contents($file);
	$arr = json_decode($str, true);
	
	return $arr;
}

function my_array_value($arr, $key, $default = '') {
    if (!is_array($arr) || !array_key_exists($key, $arr)) {
        return $default;
    }
    return $arr[$key];
}

// random_element() is included in Array Helper, so it overrides the native function
function random_element($array)
{
    shuffle($array);
    return array_pop($array);
}

function Substring($str,$start,$len){
    $str=str_replace("  "," ",$str);
    $arr=explode(" ",$str);
    if($start>count($arr))  $start=count($arr);
    $end=$start+$len;
    if($end>count($arr))    $end=count($arr);
    $newstr="";
    for($i=$start;$i<$end;$i++)
    {
        if($arr[$i]!="")
            $newstr.=$arr[$i]." ";
    }
    if($len<count($arr)) $newstr.="...";
    return $newstr;
}

function un_unicode($str){
    $marTViet=array(
        'à','á','ạ','ả','ã','â','ầ','ấ','ậ','ẩ','ẫ','ă',
        'ằ','ắ','ặ','ẳ','ẵ','è','é','ẹ','ẻ','ẽ','ê','ề'
        ,'ế','ệ','ể','ễ',
        'ì','í','ị','ỉ','ĩ',
        'ò','ó','ọ','ỏ','õ','ô','ồ','ố','ộ','ổ','ỗ','ơ'
        ,'ờ','ớ','ợ','ở','ỡ',
        'ù','ú','ụ','ủ','ũ','ư','ừ','ứ','ự','ử','ữ',
        'ỳ','ý','ỵ','ỷ','ỹ',
        'đ',
        'A','B','C','D','E','F','J','G','H','I','K','L','M',
        'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
        'À','Á','Ạ','Ả','Ã','Â','Ầ','Ấ','Ậ','Ẩ','Ẫ','Ă'
        ,'Ằ','Ắ','Ặ','Ẳ','Ẵ',
        'È','É','Ẹ','Ẻ','Ẽ','Ê','Ề','Ế','Ệ','Ể','Ễ',
        'Ì','Í','Ị','Ỉ','Ĩ',
        'Ò','Ó','Ọ','Ỏ','Õ','Ô','Ồ','Ố','Ộ','Ổ','Ỗ','Ơ'
        ,'Ờ','Ớ','Ợ','Ở','Ỡ',
        'Ù','Ú','Ụ','Ủ','Ũ','Ư','Ừ','Ứ','Ự','Ử','Ữ',
        'Ỳ','Ý','Ỵ','Ỷ','Ỹ',
        'Đ',":",",",".","?","`","~","!","@","#","$","%","^","&","*","(",")","'",'"','&','/','|','   ','  ',' ','---','--','“','”','+');

    $marKoDau=array('a','a','a','a','a','a','a','a','a','a','a',
        'a','a','a','a','a','a',
        'e','e','e','e','e','e','e','e','e','e','e',
        'i','i','i','i','i',
        'o','o','o','o','o','o','o','o','o','o','o','o'
        ,'o','o','o','o','o',
        'u','u','u','u','u','u','u','u','u','u','u',
        'y','y','y','y','y',
        'd',
        'a','b','c','d','e','f','j','g','h','i','k','l','m',
        'n','o','p','q','r','s','t','u','v','w','x','y','z',
        'a','a','a','a','a','a','a','a','a','a','a','a'
        ,'a','a','a','a','a',
        'e','e','e','e','e','e','e','e','e','e','e',
        'i','i','i','i','i',
        'o','o','o','o','o','o','o','o','o','o','o','o'
        ,'o','o','o','o','o',
        'u','u','u','u','u','u','u','u','u','u','u',
        'y','y','y','y','y',
        'd',"","","","","","","","","","","","","","",'','','','','','','',' ',' ','-','-','-',"","",'');

    $str = str_replace($marTViet, $marKoDau, $str);
    return $str;
}

function vn_str_filter ($str){
    // $newtag = str_replace(' ', '-', $str);
    $unicode = array(
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd'=>'đ',
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i'=>'í|ì|ỉ|ĩ|ị',
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D'=>'Đ|Ð',
        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );

    foreach($unicode as $nonUnicode=>$uni){
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    return $str;
}

function generateSeoURL($string, $wordLimit = 0){
    $string = vn_str_filter($string);
    $separator = '-';

    if($wordLimit != 0){
        $wordArr = explode(' ', $string);
        $string = implode(' ', array_slice($wordArr, 0, $wordLimit));
    }

    $quoteSeparator = preg_quote($separator, '#');

    $trans = array(
        '&.+?;'                    => '',
        '[^\w\d _-]'            => '',
        '\s+'                    => $separator,
        '('.$quoteSeparator.')+'=> $separator
    );

    $string = strip_tags($string);
    foreach ($trans as $key => $val){
        $string = preg_replace('#'.$key.'#i'.(UTF8_ENABLED ? 'u' : ''), $val, $string);
    }

    $string = strtolower($string);

    return trim(trim($string, $separator));
}

// Function highlight text
function highlight($inp, $words){
    $replace=array_flip(array_flip($words)); // remove duplicates
    $pattern=array();
    foreach ($replace as $k=>$fword) {
        $pattern[]='/\b(' . $fword . ')(?!>)\b/i';
        $replace[$k]='<b>$1</b>';
    }
    return preg_replace($pattern, $replace, $inp);
}

?>