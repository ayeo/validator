<?php
namespace Ayeo\Validator\Constraint;

use Libs\Form;

class Length extends \Ayeo\Validator\Constraint\AbstractValidator
{
    /**
     * @var integer
     */
    private $length;

    /**
     * @param int $length
     */
    public function __construct($length = 0)
    {
        $this->length = $length;
    }

    public function validate($fieldName, $form)
    {
        $value = (string) $this->getFieldValue($form, $fieldName);
        //var_dump($value);

        if (strlen($value) !== $this->length)
        {
            $this->error = $this->buildMessage($fieldName, 'must_be_exactly_char_length', $this->length);
        }
    }
}