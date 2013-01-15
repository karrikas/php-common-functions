<?php
/**
* Request data from form.
*
* @package fast-code-php
* @subpackage request
* @category functions
*/
/**
 * Request data.
 * @param string 	$name
 */
function request($name, $default = ''){
	if(isset($_REQUEST[$name])){
		$value = $_REQUEST[$name];
	} 
	
	if (empty($value)){ 
		$value = $default;
	}
	
	return $value;
}

/*
 * Get url from this page. 
 * @return string
 */
function requestUrl(){
	// TODO get http protocol
	return $URL = urlencode('http://' .$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
}

/**
 * Request values to url parameters.
 * @param string $without parameter not included
 * @return string
 */
function request2urlparam($without = null){
	$str = '';
	foreach($_REQUEST as $name => $value){
		if ($without != $name){
			$str .= sprintf('&amp;%s=%s', $name, $value);
		}
	}
	
	return $str;
}