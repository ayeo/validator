<?php
namespace Ayeo\Validator\Constraint;

use Libs\Form;

class NumericMax extends \Ayeo\Validator\Constraint\AbstractValidator
{
	/**
	 * @var integer
	 */
	private $max;

	/**
	 * @param int $max
	 */
	public function __construct($max = 0) //fixme: add aditional param (more or equal?)
	{
		$this->max = $max;
	}

	/**
	 * @param $fieldName
	 * @param Form\AbstractForm $form
	 * @return void
	 */
	public function validate($fieldName, $form)
	{
        $value = $this->getFieldValue($form, $fieldName);

		if (!is_numeric($value))
		{
			$this->error = $this->buildMessage($fieldName, 'must_be_numeric');
		}

		if ($value > $this->max)
		{
			$this->error = $this->buildMessage($fieldName, 'must_be_lower_than', $this->max);
		}
	}
}