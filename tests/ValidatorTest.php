<?php
namespace Ayeo\Validator\Tests;

use Ayeo\Validator\ArrayRules;
use Ayeo\Validator\Constraint\MinLength;
use Ayeo\Validator\Tests\Mock\SampleClass;
use Ayeo\Validator\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidatingTwiceInvalidObject()
    {
        $sample = new SampleClass();
        $rules = new ArrayRules([
           ['name', new MinLength(10)]
        ]);

        $validator = new Validator($rules);
        $validator->validate($sample);

        $this->assertFalse($validator->validate($sample));
    }
}