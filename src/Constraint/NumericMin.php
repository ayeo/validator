<?php
namespace Ayeo\Validator\Constraint;

use Libs\Form;

class NumericMin extends \Ayeo\Validator\Constraint\AbstractValidator
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

	public function validate($fieldName, $form)
	{
        $value = $this->getFieldValue($form, $fieldName);

		if (!is_numeric($value))
		{
			$this->error = $this->buildMessage($fieldName, 'must_be_numeric');
		}

		if ($value < $this->min)
		{
			$this->error = $this->buildMessage($fieldName, 'must_be_greater_than', $this->min);
		}
	}
}