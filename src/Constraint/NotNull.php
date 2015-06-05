<?php
namespace Ayeo\Validator\Constraint;

class NotNull extends AbstractConstraint
{
    public function run($value)
    {
        if (is_null($value))
        {
            $this->addError('must_not_be_null');
        }
    }
}