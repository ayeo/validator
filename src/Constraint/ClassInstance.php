<?php
namespace Ayeo\Validator\Constraint;

use Libs\Form;

class ClassInstance extends \Ayeo\Validator\Constraint\AbstractValidator
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

        return $value instanceof $className;
    }
}