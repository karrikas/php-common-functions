<?php
require_once dirname(__FILE__) . '/../src/date.func.php';

class dateFuncTest extends PHPUnit_Framework_TestCase
{
	public function testDateShowTime(){
		$r = dateShowTime('12:34:23');
		$this->assertEquals('12:34', $r);
	}

	public function testDateGetTime(){
		$r = dateGetTime('2011-08-19 12:14:01');
		$this->assertEquals('12:14:01', $r);
	}
}
