<?php
/**
* Work with Dates Times
*
* @package fast-code-php
* @subpackage date
* @category functions
*/
/**
 * 
 * Enter description here ...
 * @param string 	$time	Long time
 * @return string
 */
function dateShowTime($time){
	list($h, $m, $s) = explode(':', $time);
	
	return "$h:$m";
}

/**
 * Get date from datetime.
 * @param string 	$datetime 	YYYY-MM-DD HH:MM:SS
 * @return string	HH:MM:SS
 */
function dateGetDate($datetime){
	list($date, $time) = explode(' ', $datetime);
	
	return $date;
}

/**
 * Get time from datetime.
 * @param string 	$datetime 	YYYY-MM-DD HH:MM:SS
 * @return string	HH:MM:SS
 */
function dateGetTime($datetime){
	list($date, $time) = explode(' ', $datetime);
	
	return $time;
}