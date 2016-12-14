<?php
namespace Ayeo\Validator\Tests\Constraint;

use Ayeo\Validator\Constraint\NonEmpty;
use PHPUnit_Framework_TestCase;

class NonEmptyTest extends PHPUnit_Framework_TestCase
{
    public function testSomething()
    {
        $constraint = new NonEmpty();
        $constraint->run('something');
        $this->assertTrue($constraint->isValid());
    }

    public function testNullValue()
    {
        $constraint = new NonEmpty();
        $constraint->run(null);
        $this->assertFalse($constraint->isValid());
    }

    public function testZero()
    {
        $constraint = new NonEmpty();
        $constraint->run(0);
        $this->assertTrue($constraint->isValid());
    }

    public function testEmptyString()
    {
        $constraint = new NonEmpty();
        $constraint->run('');
        $this->assertFalse($constraint->isValid());
    }

    public function testEmptyArray()
    {
        $constraint = new NonEmpty();
        $constraint->run([]);
        $this->assertFalse($constraint->isValid());
    }

    public function testEmptyObject()
    {
        $constraint = new NonEmpty();
        $constraint->run(new \stdClass());
        $this->assertTrue($constraint->isValid());
    }
}