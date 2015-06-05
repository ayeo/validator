<?php
namespace Ayeo\Validator\Constraint;

use DateTime;

class DateTimeHigherThan extends AbstractConstraint
{
    /**
     * @var DateTime
     */
    private $dateTimeToCompare;

    private $format;

    public function __construct(DateTime $dateTimeToCompare, $format = 'Y-m-d')
    {
        $this->format = $format;
        $this->dateTimeToCompare = $dateTimeToCompare;
    }

    public function run($value)
    {
        if (!$value instanceof DateTime)
        {
            return $this->addError('invalid_object');
        }

        if ($value->getTimestamp() <= $this->dateTimeToCompare->getTimestamp())
        {
            $this->addError('must_be_higher_than', $this->dateTimeToCompare->format($this->format));
        }
    }
}