<?php

/**
 * Parse string to print on client.
 * @param string $string
 */
function strShow($string){
	$string = htmlentities($string, null, 'UTF-8');

	return $string;
}

/**
 * Generate a random password.
 * @return string
 */
function strPassword($lenght = 8){
	$chars = '0,1,2,3,4,5,6,7,8,9'
	. ',a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z'
	. ',A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z'
	. ',$,%,&,/,(,),=,?,-,*,-,+';

	$arrChars = explode(',', $chars);

	$result = '';

	for($i=0; $i<$lenght; $i++) {
		srand((double)microtime() * 1000000);
		shuffle($arrChars);
		$result .= $arrChars[0];
	}

	return $result;
}

/**
 * Clear string to use on urls.
 * code derived from: http://www.symfony-project.org/jobeet/1_4/Doctrine/en/08
 *
 * @param string 	$string
 * @return string
 */
function str2url($text){
	// replace non letter or digits by -
	$text = preg_replace('#[^\\pL\d]+#u', '-', $text);

	// trim
	$text = trim($text, '-');

	// transliterate
	if (function_exists('iconv'))
	{
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	}

	// lowercase
	$text = strtolower($text);

	// remove unwanted characters
	$text = preg_replace('#[^-\w]+#', '', $text);

	if (empty($text))
	{
		return 'n-a';
	}

	return $text;
}

/**
 * Text with only a-z 0-9
 * @param string $text
 * @return string
 */
function str2text($text){
	$text = preg_replace('#[^\\pL\d]+#u', '', $text);
	
	return $text;
}