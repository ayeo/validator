<?php
namespace Ayeo\Validator\Constraint;

use Libs\Form;

class DateTimeHigherThan extends \Ayeo\Validator\Constraint\AbstractValidator
{
    /**
     * @var \DateTime
     */
    private $dateTimeToCompare;

    private $format;

    public function __construct(\DateTime $dateTimeToCompare)
    {
        $this->dateTimeToCompare = $dateTimeToCompare;
    }

    public function validate($fieldName, $form)
    {
        $value = $this->getFieldValue($form, $fieldName);

        $validObject = ($value instanceof \DateTime);
        $isOk = $validObject && $value->getTimestamp() > $this->dateTimeToCompare->getTimestamp();

        if (!$isOk)
        {
            $this->error = $this->buildMessage($fieldName, 'must_be_higher_than', $this->dateTimeToCompare->format(('Y-m-d')));

            return false;
        }

        return true;
    }
}