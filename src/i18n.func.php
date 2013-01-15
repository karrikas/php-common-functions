<?php
/**
 * Work with translate formats.
 * 
 * @package fast-code-php
 * @subpackage i18n
 * @category functions
 */
/**
 * Get date in language format.
 *
 * @param string    $date   Data
 * @return string
 */
function i18nDateShow($strDate, $strLang, $separator = '/') {
	
	$arrPatr = array(
		'en' => "Y{$separator}m{$separator}d",
		'eu' => "Y{$separator}m{$separator}d",
		'es' => "d{$separator}m{$separator}Y",
	);
	
	$strPatr = isset($arrPatr[$strLang])? $arrPatr[$strLang] : $arrPatr['en'];
	
	if (($timestamp = strtotime($strDate)) === false || preg_match('/^0000\-00\-00/', $strDate)) {
		return str_replace(array('Y','m', 'd'), array('0000','00', '00'), $strPatr);
	}
	
	$strDay = date($strPatr, $timestamp);

	return $strDay;
}

/**
 * Name of weed day.
 *
 * @param string    $date   data
 * @return string
 */
function i18nDateWeekDayShow($strDate, $strLang) {
	
	$arrDays = array(
		'en' => array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'),
		'eu' => array('Igandea', 'Astelehena', 'Asteartea', 'Asteazkena', 'Osteguna', 'Ostirala', 'Larunbata'),
		'es' => array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'),
	);
	
	$strLang = isset($arrDays[$strLang])? $strLang : 'en';

	$strDay = date('w', strtotime($strDate));
	
	$strName = isset($arrDays[$strLang][$strDay])? $arrDays[$strLang][$strDay] : $strDate;

	return $strName;
}

/**
 * Transform i18n date to db format YYYY-MM-DD
 * @param string $string
 * @param string $lang
 * @param string $separator
 */
function i18nString2Date($string, $lang, $separator = '/'){
	
	$separator = str_replace('/','\/', $separator);
	
	$arrPatr = array(
		'en' => "/(?P<year>[0-9]{4})$separator(?P<month>[0-9]{2})$separator(?P<day>[0-9]{2})/",
		'eu' => "/(?P<year>[0-9]{4})$separator(?P<month>[0-9]{2})$separator(?P<day>[0-9]{2})/",
		'es' => "/(?P<day>[0-9]{2})$separator(?P<month>[0-9]{2})$separator(?P<year>[0-9]{4})/",
	);
	
	$strPatr = isset($arrPatr[$lang])? $arrPatr[$lang] : $arrPatr['en'];
	
	if(!preg_match($strPatr, $string, $r)){
		
		return $string;
	}
	
	$date = $r['year'] . '-' . $r['month'] . '-' . $r['day'] ;
	
	return $date;
}