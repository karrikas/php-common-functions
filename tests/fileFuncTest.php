<?php
require_once dirname(__FILE__) . '/../src/file.func.php';

class fileFuncTest extends PHPUnit_Framework_TestCase
{
	function testFileSizeShow(){		
		$strSize = fileSizeShow(dirname(__FILE__) . '/test.jpg');
		$this->assertEquals('3.65 kB', $strSize);		
	}
	
	function testFileTypeShow(){
		$strType = fileTypeShow(dirname(__FILE__) . '/test.jpg');
		$this->assertEquals('JPG', $strType);
	}
	
	function testFileTemplate(){
		$r = fileTemplate('test %val1% test', array('val1' => 'my text'));
		$this->assertEquals('test my text test', $r);
		
		$r = fileTemplate('test %val1% test', array());
		$this->assertEquals('test %val1% test', $r);
		
		$r = fileTemplate('test %val1% test %val1%', array('val1' => 'my text'));
		$this->assertEquals('test my text test my text', $r);
		
		$r = fileTemplate('test %val2% test %val1%', array('val1' => 'my text', 'val2' => 'my 2 text'));
		$this->assertEquals('test my 2 text test my text', $r);
	}
}
