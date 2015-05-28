<?php
namespace Ayeo\Validator;

class Validator
{
    /**
     * @var ValidationRules
     */
    private $rules;

    private $errors = [];

    /**
     * @param ValidationRules $rules
     */
    public function __construct(ValidationRules $rules)
    {
        $this->rules = $rules;
    }

    public function validate($object)
    {
        $errors = [];
        /* @var $validator AbstractValidator */
        foreach ($this->rules->getRules() as list($fieldName, $validator))
        {
            $this->klops($validator, $fieldName, $object, $errors);
        }

        $this->errors = $errors;

        return count($errors) === 0;
    }

    private function klops($validator, $fieldName, $object, &$errors)
    {
        if (is_array($validator))
        {
            $xxx = $this->getXXX($fieldName, $object);

            foreach ($validator as $row)
            {
                $xValidator = $row[1];
                $xField = $row[0];

                $this->klops($xValidator, $xField, $xxx, $errors);
            }
        }
        else
        {
            $validator->validate($fieldName, $object);
            if ($error = $validator->getError())
            {
                $errors[$fieldName] = $error;
            }

        }
    }

    private function getXXX($fieldName, $object)
    {
        $reflection = new \ReflectionClass(get_class($object));

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
            $value = $property->getValue($object);
        }
        else if ($reflection->hasMethod($methodName))
        {
            $value = call_user_func(array($object, $methodName));
        }
        else
        {
            throw new \Exception('Object has not property nor method: '. $fieldName);
        }

        return $value;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
