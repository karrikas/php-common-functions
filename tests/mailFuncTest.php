<?php
require_once dirname(__FILE__) . '/../src/mail.func.php';

class mailFuncTest extends PHPUnit_Framework_TestCase
{
	function testMailSend(){

		$this->markTestSkipped();

		$bol = mailSend('a@a.com','e@e.com', 'title', 'message');
		$this->assertTrue($bol);
	}
}
