<?php

namespace Ayeo\Validator\Tests;

use Ayeo\Validator\ArrayRules;
use Ayeo\Validator\Constraint\NotNull;
use Ayeo\Validator\Constraint\OneOf;
use Ayeo\Validator\Depend;
use Ayeo\Validator\Tests\Mock\SampleClass;
use Ayeo\Validator\Validator;
use Ayeo\Validator\Zbychu;

class TestDependandFields extends \PHPUnit_Framework_TestCase
{
    public function testCheckingNullWithNotNull()
    {
        $sample = new SampleClass();
        $sample->name = 'special-value';
        $sample->nested['min'] = 'the only valid';

        $rules = new ArrayRules([
            ['name', new NotNull()],
            ['nested', new Depend(
                [
                    new Zbychu('name', 'special-value', [
                      ['min' => new OneOf(['the only valid'])]
                    ])
                ])
            ]
        ]);

        $validator = new Validator($rules);
        $this->assertTrue($validator->validate($sample));
    }
}