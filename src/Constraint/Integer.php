<?php
namespace Ayeo\Validator\Constraint;

use Libs\Form;

class Integer extends \Ayeo\Validator\Constraint\AbstractValidator
{
    public function validate($fieldName, $form)
    {
        $value = $this->getFieldValue($form, $fieldName);

        if (is_integer($value) === false)
        {
            $this->error = $this->buildMessage($fieldName, 'must_be_integer');
        }
    }
}