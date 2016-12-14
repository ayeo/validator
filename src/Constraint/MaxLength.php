<?php
namespace Ayeo\Validator\Constraint;

class MaxLength extends AbstractConstraint
{
    /**
     * @var integer
     */
    private $max;

    /**
     * @param int $max
     */
    public function __construct($max = 0)
    {
        $this->max = $max;
    }

    public function run($value)
    {
        if (mb_strlen($value) > $this->max)
        {
            $this->addError('must_be_shorter_than', $this->max);
        }
    }
}