<?php
namespace Ayeo\Validator\Constraint;

use ReflectionClass;

abstract class AbstractConstraint
{
	/**
	 * @var string
	 */
	protected $error;

	protected $object;

	protected $fieldName;


	final public function validate()
	{
		//check if fieldname and object is set!
		$this->run($this->getFieldValue());

		return (bool)$this->error;
	}

	public function setObject($object)
	{
		if (is_object($object) === false)
		{
			//todo throw exception
		}

		$this->object = $object;
	}

	public function setFieldName($fieldName)
	{
		//check if object has property!
		//event better set it togheter
		$this->fieldName = $fieldName;
	}

	//fixem!
	protected function addError($message, $value = null)
	{
		$this->error = $this->buildMessage($this->fieldName, $message, $value);
	}

	abstract public function run($value);

	/**
	 * @return bool
	 */
	public function isValid()
	{
		return !((bool)$this->error);
	}

	/**
	 * @return string
	 */
	public function getError()
	{
		return $this->error;
	}

	/**
	 * @param string $fieldName
	 * @param string $message
	 * @param string $value
	 * @return string
	 */
	protected function buildMessage($fieldName, $message, $value = '')
	{
		$messagePattern = '%s_%s_values(/"value":"%s"/)';

		return sprintf($messagePattern, $fieldName, $message, $value);
	}

	protected function getFieldValue($fieldName = null)
	{
		if (is_null($fieldName))
		{
			$fieldName = $this->fieldName;
		}

		$object = $this->object;

		$reflection = new ReflectionClass(get_class($object));

		try
		{
			$property = $reflection->getProperty($fieldName);
		}
		catch (\Exception $e)
		{
			$property = null;
		}


		$methodName = 'get' . ucfirst($fieldName);

		if ($property && $property->isPublic())
		{
			$value = $property->getValue($object);
		}
		else if ($reflection->hasMethod($methodName))
		{
			$value = call_user_func(array($object, $methodName));
		}
		else
		{
			throw new \Exception('Object has not property nor method: ' . $fieldName);
		}

		return $value;
	}
}
