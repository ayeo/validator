<?php
namespace Ayeo\Validator\Tests\Constraint;

use Ayeo\Validator\Constraint\MaxLength;
use PHPUnit_Framework_TestCase;

class MaxLengthTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider cases
     * @param $isValid
     * @param $number
     * @param $value
     */
    public function testCases($isValid, $number, $value)
    {
        $constraint = new MaxLength($number);
        $constraint->run($value);

        $this->assertEquals($isValid, $constraint->isValid());
    }

    public function cases()
    {
        return [
            [true, 5, null],
            [true, 0, null],
            [true, 5, ''],
            [true, 0, ''],
            [true, 5, 'test'],
            [true, 4, 'test'],
            [false, 3, 'test'],
            [false, 0, 'test'],
            [true, 5, '     '],
            [true, 5, 12345],
            [true, 5, -1234],
            [false, 4, 12345],
            [false, 4, -1234],
            [true, 4, "żółć"],
            [false, 3, "żółć"],
            [true, 2, "\n\n"],
            [false, 1, "\n\n"],
        ];
    }
}