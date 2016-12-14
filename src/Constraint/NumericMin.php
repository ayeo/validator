<?php
namespace Ayeo\Validator\Constraint;

use Ayeo\Validator\Exception\InvalidConstraintParameter;

class NumericMin extends AbstractConstraint
{
	private $min;

    /**
     * @param int|float $min
     * @throws InvalidConstraintParameter
     */
	public function __construct($min = 0)
	{
        if (is_numeric($min))
        {
            $this->min = $min;
        }
        else
        {
            throw new InvalidConstraintParameter;
        }

	}

	public function run($value)
	{
		if (is_numeric($value) === false)
		{
			$this->addError('must_be_numeric');
		}

		if ($value < $this->min)
		{
			$this->addError('must_be_greater_than', $this->min);
		}
	}
}