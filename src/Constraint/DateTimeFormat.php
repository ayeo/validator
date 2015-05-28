<?php
namespace Ayeo\Validator\Constraint;

use Libs\Form;

class DateTimeFormat extends \Ayeo\Validator\Constraint\AbstractValidator
{
    /**
     * @var string
     */
    private $format;

    public function __construct($format)
    {
        $this->format = $format;
    }

    public function validate($fieldName, $form)
    {
        $value = $this->getFieldValue($form, $fieldName);
        \DateTime::createFromFormat($this->format, $value);
        $errors = \DateTime::getLastErrors();

        if (count($errors['warnings']) || count($errors['errors']))
        {
            $this->error = $this->buildMessage($fieldName, 'must_be_datetime_format', $this->format);

            return false;
        }

        return true;
    }
}