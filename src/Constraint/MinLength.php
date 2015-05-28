<?php
namespace Ayeo\Validator\Constraint;

use Libs\Form;

class MinLength extends \Ayeo\Validator\Constraint\AbstractValidator
{
    /**
     * @var integer
     */
    private $min;

    /**
     * @param int $min
     */
    public function __construct($min = 0)
    {
        $this->min = $min;
    }

    public function validate($fieldName, $form)
    {
        $value = $this->getFieldValue($form, $fieldName);

        if (strlen($value) < $this->min)
        {
            $this->error = $this->buildMessage($fieldName, 'must_be_longer_than', $this->min);
        }
    }
}