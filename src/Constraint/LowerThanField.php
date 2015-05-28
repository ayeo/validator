<?php
namespace Ayeo\Validator\Constraint;

use Libs\Form;

class LowerThanField extends \Ayeo\Validator\Constraint\AbstractValidator
{
	/**
	 * @var string
	 */
	private $field;

	/**
	 * @param $field
	 */
	public function __construct($field)
	{
		$this->field = $field;
	}

	public function validate($fieldName, $form)
	{
		if ($form->$fieldName >= $form->{$this->field})
		{
			$this->error = $this->buildMessage($fieldName, 'must_be_lower_than_'.$this->field);
		}
	}
}