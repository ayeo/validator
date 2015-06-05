<?php
namespace Ayeo\Validator\Constraint;

class NumericMax extends AbstractConstraint
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
		if (is_numeric($value) === false)
		{
			return $this->addError('must_be_numeric');
		}

		if ($value > $this->max)
		{
			return $this->addError('must_be_lower_than', $this->max);
		}
	}
}