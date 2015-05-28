<?php
namespace Ayeo\Validator\Constraint;

use Libs\Form;

class ValidObject extends \Ayeo\Validator\Constraint\AbstractValidator
{
//    public function validate($fieldName, $form)
//    {
//        $value = $this->getFieldValue($form, $fieldName);
//
//        if (!$value instanceof Form\AbstractForm)
//        {
//            $error = $this->buildMessage($fieldName, 'must_valid_object');
//            $this->error = $error;
//        }
//        else if ($value->validate() === false)
//        {
//            $errors = $value->getErrors();
//
//            $this->error = array_shift($errors);
//        }
//    }
}