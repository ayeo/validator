<?php

namespace Ayeo\Validator\Tests;

use Ayeo\Validator\ArrayRules;
use Ayeo\Validator\Constraint\MinLength;
use Ayeo\Validator\Constraint\NotNull;
use Ayeo\Validator\Constraint\OneOf;
use Ayeo\Validator\Depend;
use Ayeo\Validator\Error;
use Ayeo\Validator\MultiRule;
use Ayeo\Validator\Rule;
use Ayeo\Validator\Tests\Mock\Nested;
use Ayeo\Validator\Tests\Mock\SampleClass;
use Ayeo\Validator\Validator;
use Ayeo\Validator\Zbychu;

class NewFormatTest extends \PHPUnit_Framework_TestCase
{
    public function testTest()
    {
        $nameRule = new Rule(new MinLength(20), 'Name is to short');
        $rules = ['name' => $nameRule];

        $object = new SampleClass();
        $object->name = 'Sample name';

        $validator = new Validator(new ArrayRules($rules));
        $validator->validate($object);
        $errors = $validator->getErrors();

        $expected = [
            'name' => new Error('Name is to short', ['minLength' => 20])
        ];
        $this->assertEquals($expected, $errors);
    }

    public function testWithCode()
    {
        $nameRule = new Rule(new MinLength(20), 'Name is to short', '6637');
        $rules = ['name' => $nameRule];

        $object = new SampleClass();
        $object->name = 'Sample name';

        $validator = new Validator(new ArrayRules($rules));
        $validator->validate($object);
        $errors = $validator->getErrors();

        $expected = [
            'name' => new Error('Name is to short', ['minLength' => 20], '6637')
        ];
        $this->assertEquals($expected, $errors);
    }

    public function testTwoRulesToSingleField()
    {
        $nameRule1 = new Rule(new MinLength(4), 'Name is to short');
        $nameRule2 = new Rule(new OneOf(['type1', 'type2', 'type3']), 'Unallowed value');
        $rules = [
            'name' => new MultiRule([$nameRule1, $nameRule2])
        ];

        $object = new SampleClass();
        $object->name = 'xx';

        $validator = new Validator(new ArrayRules($rules));
        $validator->validate($object);
        $errors = $validator->getErrors();

        $expected = [
            'name' => new Error('Name is to short', ['minLength' => 4])
        ];
        $this->assertEquals($expected, $errors);
    }

    public function testNestedProperties()
    {
        $sample = new SampleClass();
        $sample->nested = new Nested();
        $sample->nested->name = "short";

        $nameRule = new Rule(new MinLength(20), 'Name is to short');
        $rules = ['nested' => ['name' => $nameRule]];

        $validator = new Validator(new ArrayRules($rules));
        $this->assertFalse($validator->validate($sample));
        $expected = [
            'nested' => [
                'name' => new Error('Name is to short', ['minLength' => 20])
            ]
        ];
        $errors = $validator->getErrors();
        $this->assertEquals($expected, $errors);
    }

    public function tesDoubletNestedProperties()
    {
        $sample = new SampleClass();
        $sample->nested = new SampleClass();
        $sample->nested->nested = new Nested();
        $sample->nested->nested->name = 'Nested name';

        $nameRule = new Rule(new MinLength(20), 'Name is to short');
        $rules = ['nested' => ['nested' => ['name' => $nameRule]]];

        $validator = new Validator(new ArrayRules($rules));
        $this->assertFalse($validator->validate($sample));
        $expected = [
            'nested' => [
                'nested' => [
                    'name' => new Error('Name is to short', ['minLength' => 20])
                ]
            ]
        ];
        $errors = $validator->getErrors();
        $this->assertEquals($expected, $errors);
    }

    public function testCheckingNullWithNotNull()
    {
        $sample = new SampleClass();
        $sample->name = 'special-value';
        $sample->nested['min'] = 'the only valid';

        $rule = new Rule(new OneOf(['the only valid']), 'Invalid value');
        $rules = new ArrayRules([
            'name' => new Rule(new NotNull(), 'Name must not be null'),
            'nested' => new Depend([new Zbychu('name', 'special-value', [$rule])])
        ]);

        $validator = new Validator($rules);
        $result = $validator->validate($sample);
        $this->assertTrue($result);
    }

    public function testCheckingNullWithNotNull2()
    {
        $sample = new SampleClass();
        $sample->name = 'special-value';
        $sample->nested['min'] = 'expected';

        $rule = new Rule(new OneOf(['the only valid']), 'Invalid value');
        $rules = new ArrayRules([
            'name' => new Rule(new NotNull(), 'Name must not be null'),
            'nested' => new Depend([new Zbychu('name', 'special-value', ['min' => $rule])])
        ]);

        $validator = new Validator($rules);
        $this->assertFalse($validator->validate($sample));
        $expected = [
            'nested' => [
                'min' => new Error('Invalid value', ['allowedValues' => ['the only valid']])
            ]
        ];
        $errors = $validator->getErrors();
        $this->assertEquals($expected, $errors);
    }
}