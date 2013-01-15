<?php
require_once dirname(__FILE__) . '/../request.func.php';

class requestFuncTest extends PHPUnit_Framework_TestCase
{
	function testRequest(){
		$_REQUEST['test'] = 'valor_test';
		$r = request('test');
		$this->assertEquals($r,'valor_test');
	}
}