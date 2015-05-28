<?php
namespace Ayeo\Validator\Constraint;

use Exception;
use Libs\Form;

class ExistingDaoObject extends \Ayeo\Validator\Constraint\AbstractValidator
{
	/**
	 * @var string
	 */
	private $className = '';

	/**
	 * @param $className
	 */
	public function __construct($className)
	{
		$this->className = $className;
	}

	public function validate($fieldName, $form)
	{
		try
		{
			if (!class_exists($this->className))
			{
				throw new Exception;
			}

			if (!is_subclass_of($this->className, '\DAO_DAO'))
			{
				throw new Exception;
			}

			call_user_func(array($this->className, 'find'), $form->$fieldName->id);
		}
		catch (Exception $e)
		{
			$this->error = 'selected_category_is_invalid';
		}
	}

}