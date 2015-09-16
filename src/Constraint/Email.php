<?php
namespace Ayeo\Validator\Constraint;

class Email extends AbstractConstraint
{
    public function run($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL))
        {
            return true;
        }

        $this->addError('invalid_email_format');
    }
}