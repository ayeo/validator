<?php
namespace Ayeo\Validator\Constraint;

class CollectionMinItems extends AbstractConstraint
{
	/**
	 * @var integer
	 */
	private $min;

	/**
	 * @param int $min
	 */
	public function __construct($min = 1)
	{
		$this->min = $min;
	}

	public function run($value)
	{
		if (count($value) < $this->min)
		{
			$this->addError('must_contain_at_least_x_items', $this->min);
		}
	}
}