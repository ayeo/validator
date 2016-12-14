<?php
namespace Ayeo\Validator\Constraint;

class MinLength extends AbstractConstraint
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

    public function run($value)
    {
        if (mb_strlen($value) < $this->min)
        {
            $this->addError('must_be_longer_than', $this->min);
        }
    }
}