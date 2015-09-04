<?php
namespace Ayeo\Validator;

class Validator
{
    /**
     * @var ValidationRules
     */
    private $rules;

    private $errors = [];

    private $invalidFields = [];

    /**
     * @param ValidationRules $rules
     */
    public function __construct(ValidationRules $rules)
    {
        $this->rules = $rules;
    }

    public function validate($object)
    {
        $this->invalidFields = []; //this fixes issue if validate twice invalid object, second try returns true
        $errors = [];
        /* @var $validator AbstractValidator */
        foreach ($this->rules->getRules() as list($fieldName, $validator))
        {
            $this->processValidation($validator, $fieldName, $object, $errors);
        }

        $this->errors = $errors;

        return count($errors) === 0;
    }

    private function processValidation($validator, $fieldName, $object, &$errors)
    {
        if (is_array($validator))
        {
            $nestedObject = $this->getFieldValue($fieldName, $object);

            foreach ($validator as $row)
            {
                $xValidator = $row[1];
                $xField = $row[0];

                $this->processValidation($xValidator, $xField, $nestedObject, $errors);
            }
        }
        else
        {
            if (in_array($fieldName, $this->invalidFields))
            {
                return;
            }

            $validator->setObject($object);
            $validator->setFieldName($fieldName);
            $validator->validate();

            if ($error = $validator->getError())
            {
                $this->invalidFields[] = $fieldName;
                $errors[$fieldName] = $error;
            }

        }
    }

    private function getFieldValue($fieldName, $object)
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
