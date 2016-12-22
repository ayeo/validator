<?php
namespace Ayeo\Validator\Constraint;

use Ayeo\Validator\CheckNull;
use Ayeo\Validator\Error;
use ReflectionClass;

abstract class AbstractConstraint
{
	/**
	 * @var string
	 */
	protected $error;

	protected $object;

	protected $fieldName;

	public function setDefaultValue($value)
	{
		if (is_null($this->object->{$this->fieldName})) {
		    $this->object->{$this->fieldName} = $value;
		}
	}

	final public function validate()
	{
        $value = $this->getFieldValue();
        if (is_null($value)) {
            if ($this instanceof CheckNull === false) {
                return true;
            }

        };

        $this->run($value);

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

	protected function addError($message, $value = null)
	{
		$this->error = new Error(sprintf("%s_%s", $this->fieldName, $message), $value);
	}

	abstract public function run($value);

	/**
	 * @return bool
	 */
	public function isValid()
	{
		return !((bool)$this->error);
	}

	public function hasError()
    {
        return is_null($this->error) === false;
    }

	public function getError(): Error
	{
	    if ($this->hasError() === false) {
	        throw new \LogicException("There is no error");
        }

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
