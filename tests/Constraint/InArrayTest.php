<?php
namespace Ayeo\Validator\Tests\Constraint;

use Ayeo\Validator\Constraint\InArray;

class InArrayTest extends \PHPUnit_Framework_TestCase
{
    public function testBase()
    {
        $constraint = new InArray([1, 2, 3]);
        $constraint->run(4);
        $this->assertFalse($constraint->isValid());
    }

    public function testNull()
    {
        $constraint = new InArray([1, 2, 3]);
        $constraint->run(null);
        $this->assertFalse($constraint->isValid());
    }
}