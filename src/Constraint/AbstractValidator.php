<?php
namespace Ayeo\Validator\Constraint;

use Libs\Form\AbstractForm;

abstract class AbstractValidator
{
	/**
	 * @var string
	 */
	protected $error;

	/**
	 * @param $fieldName
	 * @param AbstractForm $form
	 * @return void
	 */
	abstract public function validate($fieldName, $form);

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

    /**
     * @param AbstractForm $form
     * @param $fieldName
     * @return mixed
     * @throws \Exception
     */
    protected function getFieldValue($form, $fieldName)
    {
        $reflection = new \ReflectionClass(get_class($form));
        try
        {
            $property = $reflection->getProperty($fieldName);
        }
        catch (\Exception $e)
        {
            $property = null;
        }


        $methodName = 'get'.ucfirst($fieldName);

        if ($property && $property->isPublic())
        {
            $value = $property->getValue($form);
        }
        else if ($reflection->hasMethod($methodName))
        {
            $value = call_user_func(array($form, $methodName));
        }
        else
        {
            throw new \Exception('Object has not property nor method: '. $fieldName);
        }

        return $value;
    }


}