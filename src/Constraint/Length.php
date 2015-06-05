<?php
namespace Ayeo\Validator\Constraint;

class Length extends AbstractConstraint
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

    public function run($value)
    {
        if (mb_strlen($value) !== $this->length)
        {
            $this->addError('must_be_exactly_char_length', $this->length);
        }
    }
}