<?php
namespace Ayeo\Validator\Tests\Constraint;

use Ayeo\Validator\Constraint\IsArray;

class IsArrayTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider invalidDataProvider
	 */
    public function testInvalidData($value)
    {
        $constraint = new IsArray();
        $constraint->run($value);
        $this->assertFalse($constraint->isValid());
    }

	/**
	 * @dataProvider validDataProvider
	 */
    public function testValidData($value)
    {
        $constraint = new IsArray();
        $constraint->run($value);
        $this->assertTrue($constraint->isValid());
    }

	public function invalidDataProvider()
	{
		return [
			'string' => ['string'],
			'string2' => ['[]'],
			'int' => [12],
			'float' => [198.89],
			'boolean' => [true],
			'boolean2' => [false],
			'object' => [new \stdClass()],
			'null' => [null],
		];
    }

	public function validDataProvider()
	{
		return [
			[[1, 2, 3]],
			[['a', 'b']],
			[['a' => 'c', 'b' => 'd']],
		];
    }
}