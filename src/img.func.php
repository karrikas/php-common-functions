<?php
require_once dirname(__FILE__) . '/fastGd.class.php';
/**
 * Easy way to work with images.
 * 
 * @package fast-code-php
 * @subpackage mail
 * @category img
 */

/**
 * Create a image thumb.
 * 
 * @param 	string 		$file		File path.
 * @param	integer 	$size		Image with and height.
 */
function imgThumb($file, $size){
	fastGd::source($file)->thumb($size)->output();
}
