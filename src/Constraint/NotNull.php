<?php
namespace Ayeo\Validator\Constraint;

use Libs\Form;

class NotNull extends \Ayeo\Validator\Constraint\AbstractValidator
{
    public function validate($fieldName, $form)
    {
        $value = $this->getFieldValue($form, $fieldName);

        if (is_null($value))
        {
            $this->error = $this->buildMessage($fieldName, 'must_not_be_null');
        }
    }
}