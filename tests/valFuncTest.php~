<?php
require_once dirname(__FILE__) . '/../val.func.php';

class valFuncTest extends PHPUnit_Framework_TestCase
{
	function testValInteger(){
		$r = valInteger(1);
		$this->assertTrue($r);
		
		$r = valInteger(0);
		$this->assertTrue($r);
		
		$r = valInteger('33');
		$this->assertTrue($r);
		
		$r = valInteger('a');
		$this->assertFalse($r);
		
		$r = valInteger(2.5);
		$this->assertFalse($r);
		
		$r = valInteger('2.5');
		$this->assertFalse($r);
	}
	
	function testValEmail(){
		$r = valEmail('no email');
		$this->assertFalse($r);
		
		$r = valEmail('email@email.com');
		$this->assertTrue($r);
		
		$r = valEmail('email+email@email.co.uk');
		$this->assertTrue($r);
	}
	
	function testValUrl(){
		$r = valUrl('http://myurl.com');
		$this->assertTrue($r);
	}
}