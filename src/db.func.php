<?php
/**
* Work with DB info.
*
* @package fast-code-php
* @subpackage db
* @category functions
*/

/**
 * Convert mysql_query result 2 array
 * @param object 	$resource 	mysql_query 
 * @param string	$type		Type of conversion
 * @return array|false
 */
function db2array($resource){
	
	$result = array();
	while($data = mysql_fetch_assoc($resource)){
		$result[] = $data;
	}
	
	if (empty($result)){
		return false;
	}
	
	return $result;
}

/**
 * Paginate a array.
 * 
 * @param array 	$arr	Data to paginate
 * @param integer 	$page	Current page
 * @param integer 	$rows	Rows by page
 */
function dbArrPaginateRows($arr, $page=1, $rows=5){
	
	if(!$arr){
		return $arr;
	}
	
	list($initialRow, 
		$lastRow, 
		$totalRows) = dbArrPaginateNavigation($arr, $page, $rows);
	
	$result = array();
	for($i=$initialRow-1; $i<$lastRow; $i++){
		$result[] = $arr[$i];
	}
	
	return $result;
}

/**
 * Navigation data to paginate a array
 * @param array 	$arr	Data to paginate
 * @param integer 	$page	Current page
 * @param integer 	$rows	Rows by page
 * @return array	retur<br>
 * 					0. integer Initial Row<br>
 * 					1. integer Last Row<br>
 * 					2. integer Total Rows<br>
 * 					3. integer Current page<br>
 * 					4. integer Total pages<br>
 * 					5. boolean Previous page<br>
 * 					6. boolean Next page
 */
function dbArrPaginateNavigation($arr, $page=1, $rows=5){
	
	$result = array();
	
	// initial row
	$result[0] = (($page - 1) * $rows) + 1;
	
	// total rows
	$result[2] = count($arr);
	
	// last row
	$lastRow = ($result[0] - 1) + $rows;
	if($lastRow > $result[2]){
		$lastRow = $result[2];
	}
	$result[1] = $lastRow;
	
	// current page
	$result[3] = $page;
	
	// total pages
	$result[4] = ceil($result[2] / $rows);
	
	// Previous page
	$result[5] = ($result[3] > 1);
	
	// Next page
	$result[6] = ($result[3] < $result[4]);
	
	ksort($result);
	
	return $result;
}