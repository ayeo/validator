<?php
namespace Ayeo\Validator\Tests\Constraint;

use Ayeo\Validator\Constraint\NumericMin;
use PHPUnit_Framework_TestCase;

class NumericMinTest extends PHPUnit_Framework_TestCase
{
    public function testNoNumeric()
    {
        $constraint = new NumericMin(10);
        $constraint->run('string');
        $this->assertFalse($constraint->isValid());
    }

    public function testEmptyParameter()
    {
        $constraint = new NumericMin();
        $constraint->run('string');
        $this->assertFalse($constraint->isValid());
    }

    /**
     * @expectedException \Ayeo\Validator\Exception\InvalidConstraintParameter
     */
    public function testStringParameter()
    {
        $constraint = new NumericMin('string');
        $constraint->run('string');
        $this->assertFalse($constraint->isValid());
    }

    public function testCompareEquals()
    {
        $constraint = new NumericMin(12);
        $constraint->run(12);
        $this->assertTrue($constraint->isValid());
    }

    //should pass through
    public function testCompareEqualsFloat()
    {
        $constraint = new NumericMin(12.00000009);
        $constraint->run(12);
        $this->assertFalse($constraint->isValid());
    }
}