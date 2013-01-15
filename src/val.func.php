<?php
/**
* Validation functions.
*
* @package fast-code-php
* @subpackage val
* @category functions
*/
/**
 * Validate a integer value.
 * @param string 	$value
 * @return boolean
 */
function valInteger($value){
	if (is_int($value)){
		return true;
	} 
	
	if(preg_match('/^[0-9]+$/', $value)){
		return true;
	}
	
	return false;
}

/**
 * Validate a email.
 * @param string $value Email
 * @return boolean
 */
function valEmail($value){
	return filter_var($value, FILTER_VALIDATE_EMAIL)? true : false;
}

/**
* Validate a url.
* @param string $value Email
* @return boolean
*/
function valUrl($value){
	return filter_var($value, FILTER_VALIDATE_URL)? true : false;
}
