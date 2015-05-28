<?php
namespace Ayeo\Validator\Constraint;

use Libs\Form;

class NotClassInstance extends \Ayeo\Validator\Constraint\AbstractValidator
{
    /**
     * @var string
     */
    private $className;

    public function __construct($className)
    {
        $this->className = $className;
    }

    public function validate($fieldName, $form)
    {
        $value = $this->getFieldValue($form, $fieldName);
        $className = $this->className;

        if ($value instanceof $className)
        {
            $this->error = $this->buildMessage($fieldName, 'must_not_be_instance', $this->className);

            return false;
        }

        return true;
    }
}