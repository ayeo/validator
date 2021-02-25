<?php
namespace Ayeo\Validator\Tests\Constraint;

use Ayeo\Validator\Constraint\ArrayOfType;
use PHPUnit_Framework_TestCase;

class ArrayOfTypeTest extends PHPUnit_Framework_TestCase
{
    public function testIntegersList()
    {
        $constraint = new ArrayOfType('integer');
        $constraint->run([1, 2, 10, 199]);

        $this->assertTrue($constraint->isValid());
    }

    public function testNumericString()
    {
        $constraint = new ArrayOfType('integer');
        $constraint->run([1, 2, 10, "199"]);

        $this->assertFalse($constraint->isValid());
    }

    public function testEmpty()
    {
        $constraint = new ArrayOfType('integer');
        $constraint->run([]);

        $this->assertTrue($constraint->isValid());
    }
}
