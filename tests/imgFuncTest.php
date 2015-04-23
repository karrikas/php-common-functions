<?php
require_once dirname(__FILE__) . '/../src/img.func.php';

class imgFuncTest extends PHPUnit_Framework_TestCase
{
	/**
	 * TODO: how test this
	 */
	function testImgThumb(){
		$this->markTestSkipped('how test this');
		imgThumb('test.jpg', 200);		
	}
}
