<?php
namespace Ayeo\Validator\Constraint;

class NonEmpty extends AbstractConstraint
{
    public function run($value)
    {
        if ($value === 0 || $value === '0')
        {
            return;
        }

        if (empty($value))
        {
            $this->addError('must_not_be_empty');
        }
    }
}