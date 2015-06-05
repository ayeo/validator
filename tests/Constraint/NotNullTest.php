<?php
namespace Ayeo\Validator\Tests\Constraint;

use Ayeo\Validator\Constraint\NotNull;
use PHPUnit_Framework_TestCase;

class NotNullTest extends PHPUnit_Framework_TestCase
{
    public function testNullValue()
    {
        $constraint = new NotNull();
        $constraint->run(null);
        $this->assertFalse($constraint->isValid());
    }

    public function testZero()
    {
        $constraint = new NotNull();
        $constraint->run(0);
        $this->assertTrue($constraint->isValid());
    }

    public function testEmptyString()
    {
        $constraint = new NotNull();
        $constraint->run('');
        $this->assertTrue($constraint->isValid());
    }
}