<?php
/**
 * Function to work with files.
 *
 * @package fast-code-php
 * @subpackage file
 * @category functions
 */

/**
 * Show file size string.
 * 
 * @param string    $file   file path
 * @return string
 */
function fileSizeShow($file) {

    // sizes names
    $arrNames = array(1 => 'kB', 'MB', 'GB', 'TB');

    $size = filesize($file);
    $count = 0;

    while ($size > 1024) {
        $size /= 1024;
        $count++;
    }

    // irteera formatoa
    $show = round($size, 2) . ' ' . $arrNames[$count];

    return $show;
}

/**
 * Get file type by extension
 * 
 * @param string    $file   File name.
 * @return string
 */
function fileTypeShow($file) {

    $type = pathinfo($file, PATHINFO_EXTENSION);

    return strtoupper($type);
}

/**
 * Replace values y html content.
 * @param string	$template 	Html template with values same this %val1%, %val2%, ...
 * @param array 	$values		Sustitution for %val1%<br>
 * 								array('val1' => 'my value',...)
 */
function fileTemplate($template, $values){
	
	if(empty($values)){
		return $template;
	}
	
	foreach($values as $name => $value){
		$template = str_replace("%$name%", $value, $template);
	}
	
	return $template;
}