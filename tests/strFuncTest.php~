<?php
require_once dirname(__FILE__) . '/../str.func.php';

class strFuncTest extends PHPUnit_Framework_TestCase
{
	function testStrShow(){
		$r = strShow('test');
		$this->assertEquals($r, 'test');
	}
	
	function testStrPassword(){
		$r = strPassword();
		$this->assertEquals(8, strlen($r));
	}
}