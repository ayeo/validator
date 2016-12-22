<?php
namespace Ayeo\Validator\Tests;

use Ayeo\Validator\ArrayRules;
use Ayeo\Validator\Constraint\CollectionMinItems;
use Ayeo\Validator\Constraint\MinLength;
use Ayeo\Validator\Constraint\NotNull;
use Ayeo\Validator\Tests\Mock\SampleClass;
use Ayeo\Validator\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testCheckingNullWithNotNull()
    {
        $sample = new SampleClass();
        $rules = new ArrayRules([
            ['name', new NotNull()] //, new MinLength(10)
        ]);

        $validator = new Validator($rules);
        $result = $validator->validate($sample);
        $this->assertFalse($result);
    }

    //should skip validating null field
    public function testCheckingNull()
    {
        $sample = new SampleClass();
        $rules = new ArrayRules([
            ['name', new MinLength(10)]
        ]);

        $validator = new Validator($rules);
        $result = $validator->validate($sample);
        $this->assertTrue($result);
    }

    public function testDefaultValue()
    {
        $sample = new SampleClass();
        $rules = new ArrayRules([
            ['name', new MinLength(10), "Unknown name"]
        ]);

        $validator = new Validator($rules);
        $validator->validate($sample);
        $this->assertEquals("Unknown name", $sample->name);
    }

    public function testNotNull()
    {
        $sample = new SampleClass();
        $rules = new ArrayRules([
            ['name', new NotNull()],
            ['name', new MinLength(10)]
        ]);

        $validator = new Validator($rules);
        $this->assertFalse($validator->validate($sample));
    }
}