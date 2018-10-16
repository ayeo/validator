<?php

namespace Ayeo\Validator\Constraint;

class ValidRegexp extends AbstractConstraint
{
    public function run($regex)
    {
        if (@preg_match($regex, null) === false) {
            $this->addError('Invalid regexp');
        }
    }
}
