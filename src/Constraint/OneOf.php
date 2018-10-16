<?php
namespace Ayeo\Validator\Constraint;

class OneOf extends AbstractConstraint
{
    public function __construct(array $allowedValues)
    {
        $this->allowedValues = $allowedValues;
    }

    public function run($value)
    {
        if (in_array($value, $this->allowedValues) === false) {
            $this->addError('not_allowed_value');
        }
    }
}
