<?php

namespace WePay\Common;

/**
 * @coversDefaultClass WePay\Common\Enum
 * @covers ::<protected>
 * @covers ::<private>
 */
class EnumTest extends \PHPUnit_Framework_TestCase {


	/**
	 * @covers ::__construct
	 * @expectedException UnexpectedValueException
	 * @expectedExceptionMessage Value not a const in enum WePay\Common\EnumFixture
	 */
	public function testBadValueInConstructThrows() {
		new EnumFixture(13);
	}

	/**
	 * @covers ::__construct
	 */
	public function testGoodValueInConstruct() {
		$this->assertInstanceOf('WePay\Common\Enum', new EnumFixture(EnumFixture::May));
	}

	/**
	 * @covers ::__construct
	 */
	public function testEmptyConstructUsesDefault() {
		$this->assertInstanceOf('WePay\Common\Enum', new EnumFixture);
	}

	/**
	 * @covers ::__construct
	 * @expectedException UnexpectedValueException
	 */
	public function testNoDefaultEnumThrowsOnConstruct() {
		new NoDefaultEnumFixture;
	}

	/**
	 * @covers ::is
	 */
	public function testIsMatch() {
		$f = new EnumFixture(EnumFixture::January);
		$this->assertTrue($f->is(EnumFixture::January));
	}

	/**
	 * @covers ::is
	 */
	public function testIsNoMatch() {
		$f = new EnumFixture(EnumFixture::February);
		$this->assertFalse($f->is(EnumFixture::January));
	}

	/**
	 * @covers ::getConstList
	 */
	public function testGetConstListWithDefault() {
		$exp =
			[ '__default' => 1
			, 'January' => 1
			, 'February' => 2
			, 'March' => 3
			, 'April' => 4
			, 'May' => 5
			, 'June' => 6
			, 'July' => 7
			, 'August' => 8
			, 'September' => 9
			, 'October' => 10
			, 'November' => 11
			, 'December' => 12
			];
		$month = new EnumFixture;
		$this->assertEquals($exp, $month->getConstList(true));
	}

	/**
	 * @covers ::getConstList
	 */
	public function testGetConstListWithoutDefault() {
		$exp =
			[ 'January' => 1
			, 'February' => 2
			, 'March' => 3
			, 'April' => 4
			, 'May' => 5
			, 'June' => 6
			, 'July' => 7
			, 'August' => 8
			, 'September' => 9
			, 'October' => 10
			, 'November' => 11
			, 'December' => 12
			];
		$month = new EnumFixture;
		$this->assertEquals($exp, $month->getConstList(false));
	}

	/**
	 * @covers ::getValue
	 */
	public function testGetValueWithDefault() {
		$m = new EnumFixture;
		$this->assertEquals(EnumFixture::__default, $m->getValue());
	}

	/**
	 * @covers ::getValue
	 */
	public function testGetValueSpecifiedInConstruct() {
		$m = new EnumFixture(EnumFixture::May);
		$this->assertEquals(EnumFixture::May, $m->getValue());
	}

	/**
	 * @covers ::__invoke
	 */
	public function testInvokeReturnsValue() {
		$m = new EnumFixture(EnumFixture::May);
		$this->assertEquals(EnumFixture::May, $m());
	}

	/**
	 * @covers ::__callStatic
	 */
	public function testStaticInvocationReturnsEnum() {
		$exp = new EnumFixture(EnumFixture::May);
		$this->assertEquals($exp, EnumFixture::May(), 'Calling constant as function should return the enum');
	}

	/**
	 * @covers ::__callStatic
	 * @expectedException UnexpectedValueException
	 * @expectedExceptionMessage Value 'WePay\Common\EnumFixture::NonDefinedConstant' not a const in enum WePay\Common\EnumFixture
	 */
	public function testStaticInvocationOfUndefinedValueThrows() {
		EnumFixture::NonDefinedConstant();
	}

}

class EnumFixture extends Enum {

    const __default = self::January;

    const January = 1;
    const February = 2;
    const March = 3;
    const April = 4;
    const May = 5;
    const June = 6;
    const July = 7;
    const August = 8;
    const September = 9;
    const October = 10;
    const November = 11;
    const December = 12;
}

class NoDefaultEnumFixture extends Enum {

	const ONE = 1;
	const TWO = 2;

}

