<?php
namespace Ayeo\Validator\Tests\Constraint;

use Ayeo\Validator\Constraint\MinLength;
use PHPUnit_Framework_TestCase;

class MinLengthTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider cases
     * @param $isValid
     * @param $number
     * @param $value
     */
    public function testCases($isValid, $number, $value)
    {
        $constraint = new MinLength($number);
        $constraint->run($value);

        $this->assertEquals($isValid, $constraint->isValid());
    }

    public function cases()
    {
        return [
            [false, 5, null],
            [true, 0, null],
            [false, 5, ''],
            [true, 0, ''],
            [false, 5, 'test'],
            [true, 4, 'test'],
            [true, 3, 'test'],
            [true, 0, 'test'],
            [true, 5, '     '],
            [true, 5, 12345],
            [true, 5, -1234],
            [false, 6, 12345],
            [false, 6, -1234],
            [true, 4, "żółć"],
            [false, 5, "żółć"],
            [true, 2, "\n\n"],
            [false, 3, "\n\n"],
        ];
    }
}