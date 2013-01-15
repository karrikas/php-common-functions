<?php
require_once dirname(__FILE__) . '/../db.func.php';

class dbFuncTest extends PHPUnit_Framework_TestCase
{
	protected function setUp(){
		$server = 'localhost';
		$db_user = 'root';
		$db_pass = '';
		$database = 'test';
		
		$cmd = "mysql -u $db_user $database < test.sql";
		exec($cmd);
		
		// conectar a db
		$this->link = @mysql_connect($server, $db_user, $db_pass);
		$this->link_db = @mysql_select_db($database, $this->link);
	}
	
	function testDbArrPaginateRows(){
		$arr = range(0, 12);
		$r = dbArrPaginateRows($arr);
		
		$this->assertEquals(count($r), 5);
		
		$r = dbArrPaginateRows($arr, 2);
		$this->assertEquals(count($r), 5);
		
		$r = dbArrPaginateRows($arr, 3);
		$this->assertEquals($r, array(10, 11, 12));
		
		$r = dbArrPaginateRows($arr, 13, 1);
		$this->assertEquals($r, array(12));
		
		$r = dbArrPaginateRows($arr, 3, 1);
		$this->assertEquals($r, array(2));
	}
	
	function testDbArrPaginateNavigation(){
		$arr = range(0, 12);
		$r = dbArrPaginateNavigation($arr);
		$this->assertEquals($r, array(
			1, 5, 13, 1, 3, false, true
		)); 
		
		$r = dbArrPaginateNavigation($arr, 2);
		$this->assertEquals($r, array(
			6, 10, 13, 2, 3, true, true
		));
		
		$r = dbArrPaginateNavigation($arr, 3);
		$this->assertEquals($r, array(
			11, 13, 13, 3, 3, true, false
		));
		
		$r = dbArrPaginateNavigation($arr, 1, 1);
		$this->assertEquals($r, array(
		1, 1, 13, 1, 13, false, true
		));
		
		$r = dbArrPaginateNavigation($arr, 3, 1);
		$this->assertEquals($r, array(
		3, 3, 13, 3, 13, true, true
		));
	}
	
	function testDb2array(){
		$sql = 'SELECT * FROM table_1';
		$resource = mysql_query($sql);
		$r = db2array($resource);
		
		$this->assertInternalType('array',$r);
		$this->assertEquals(13,count($r));
		
		$sql = 'SELECT * FROM table_1 WHERE 1=0';
		$resource = mysql_query($sql);
		$r = db2array($resource);
		$this->assertFalse($r);
	}
}