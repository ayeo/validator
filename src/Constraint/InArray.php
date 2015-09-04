<?php
namespace Ayeo\Validator\Constraint;

class InArray extends AbstractConstraint
{
    private $array;

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function run($value)
    {
        if (in_array($value, $this->array) === false)
        {
            $this->addError('Given value is not allowed');
        }
    }
}