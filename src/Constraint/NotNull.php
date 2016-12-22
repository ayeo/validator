<?php
namespace Ayeo\Validator\Constraint;

use Ayeo\Validator\CheckNull;

class NotNull extends AbstractConstraint implements CheckNull
{
    public function run($value)
    {
        if (is_null($value))
        {
            $this->addError('must_not_be_null');
        }
    }
}