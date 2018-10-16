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
        foreach ($this->rules->getRules() as $x => list($fieldName, $validator))
        {
            $defaultValue = $this->rules->getDefaultValue($x);
            $this->processValidation($validator, $fieldName, $object, $errors, $defaultValue);
        }

        $this->errors = $errors;

        return count($this->getErrors()) === 0;
    }

    private function processValidation($validator, $fieldName, $object, &$errors, $defaultValue = null)
    {
        if (is_array($validator))
        {
            $nestedObject = $this->getFieldValue($fieldName, $object);
            if (is_null($nestedObject))
            {
                $nestedObject = $defaultValue;
            }

            $xValidator = $validator[1];
            $xField = $validator[0];
            $this->processValidation($xValidator, $xField, $nestedObject, $errors, $defaultValue);
        }
        elseif ($validator instanceof Depend) {
            foreach ($validator->getZbychus() as $zbychu) {
                $a = $this->getFieldValue($zbychu->getFieldName(), $object);
                $b = $zbychu->getExpectedValue();
                if ($a == $b) {
                    foreach ($zbychu->getRules() as $xxx) {
                        foreach ($xxx as $xxField => $xxValidator) {
                            $nestedObject = $this->getFieldValue($fieldName, $object);
                            $this->processValidation($xxValidator, $xxField, (object)$nestedObject, $errors[$fieldName], $xxx[2] ?? null);
                        }
                    }
                }
            }
        } else {
            if (in_array($fieldName, $this->invalidFields))
            {
                return;
            }

            $validator->setObject($object);
            $validator->setFieldName($fieldName);
            //$validator->setDefaultValue($defaultValue);
            $validator->validate();

            if ($validator->hasError()) {
                $this->invalidFields[] = $fieldName;
                $errors[$fieldName] = $validator->getError();
            }
        }
    }

    private function getFieldValue($fieldName, $object)
    {
        if ($object instanceof \stdClass) {
            return $object->$fieldName;
        }

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
            $value = null;
            //throw new \Exception('Object has not property nor method: '. $fieldName);
        }

        return $value;
    }

    public function getErrors($x = false)
    {
        foreach ($this->errors as $key => $value) {
            if (is_null($value)) {
                unset($this->errors[$key]);
            }
        }

        if ($x) {
            return array_values($this->errors);
        }
        return $this->errors;
    }
}
