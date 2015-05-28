<?php
namespace Ayeo\Validator\Constraint;

use Libs\Form;

class CollectionMinItems extends \Ayeo\Validator\Constraint\AbstractValidator
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

	public function validate($fieldName, $form)
	{
		if (count($form->$fieldName) < $this->min)
		{
			$this->error = $this->buildMessage($fieldName, 'must_contain_at_least_x_items', $this->min);
		}
	}
}