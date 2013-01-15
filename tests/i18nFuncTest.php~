<?php
require_once dirname(__FILE__) . '/../i18n.func.php';

class i18nFuncTest extends PHPUnit_Framework_TestCase
{
	public function testI18nDateShow(){
		$date = i18nDateShow('2011-12-14', 'es');
		$this->assertEquals('14/12/2011', $date);

		$date = i18nDateShow('2011-12-14', 'eu');
		$this->assertEquals('2011/12/14', $date);

		$date = i18nDateShow('2011-01-02', 'es');
		$this->assertEquals('02/01/2011', $date);
	}

	public function testI18nDateWeekDayShow(){
		$day = i18nDateWeekDayShow('2011-08-19', 'en');
		$this->assertEquals('Friday', $day);
		
		$day = i18nDateWeekDayShow('2011-08-19', 'eu');
		$this->assertEquals('Ostirala', $day);
		
		$day = i18nDateWeekDayShow('2011-08-19', 'es');
		$this->assertEquals('Viernes', $day);
	}
	
	public function testI18nString2Date(){
		$r = i18nString2Date('2011/08/19', 'en');
		$this->assertEquals('2011-08-19', $r);
		
		$r = i18nString2Date('19-07-2001', 'es', '-');
		$this->assertEquals('2001-07-19', $r);
	}
}