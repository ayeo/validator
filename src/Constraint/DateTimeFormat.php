<?php
namespace Ayeo\Validator\Constraint;

class DateTimeFormat extends AbstractConstraint
{
    /**
     * @var string
     */
    private $format;

    public function __construct($format)
    {
        $this->format = $format;
    }

    public function run($value)
    {
        \DateTime::createFromFormat($this->format, $value);
        $errors = \DateTime::getLastErrors();

        if (count($errors['warnings']) || count($errors['errors']))
        {
            $this->addError('must_be_datetime_format', $this->format);
        }
    }
}