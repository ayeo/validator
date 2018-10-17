<?php
namespace Ayeo\Validator;

class Validator
{
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
        $rules = $this->rules->getRules();
        foreach ($rules as $fieldName => $rule) {
            $this->processValidation($rule, $fieldName, $object, $errors);
        }
        $this->errors = $errors;

        return count($this->getErrors()) === 0;
    }

    private function processValidation($rule, string $fieldName, $object, array &$errors = [])
    {
        if (isset($errors[$fieldName]) === false) {
            $errors[$fieldName] = [];
        }


        if (is_array($rule)) {
            foreach ($rule as $xFieldName => $xRule) {
                if (isset($errors[$fieldName]) === false) {
                    $errors[$fieldName] = [];
                }
                $nestedObject = $this->getFieldValue($fieldName, $object);
                $this->processValidation($xRule, $xFieldName, $nestedObject, $errors[$fieldName]);
            }

            return;
        }

        if ($rule instanceof MultiRule) {
            foreach ($rule->getRules() as $xxRule) {
                $this->processValidation($xxRule, $fieldName, $object, $errors);
            }

            return;
        }


        if ($rule instanceof Depend) {
            foreach ($rule->getZbychus() as $zbychu) {
                $nestedObject = (object)$this->getFieldValue($fieldName, $object);
                $a = $this->getFieldValue($zbychu->getFieldName(), $object);
                $b = $zbychu->getExpectedValue();
                if ($a == $b) {
                    foreach ($zbychu->getRules() as $yy => $xxx) {
                        $this->processValidation($xxx, $yy, $nestedObject, $errors[$fieldName]);
                    }
                }
            }
        } else {
            $validator = $rule->getConstraint();
            if (in_array($fieldName, $this->invalidFields)) {
                return;
            }

            $value = $this->getFieldValue($fieldName, $object);
            $result = $validator->validate($value);

            if ($result === false) {
                $this->invalidFields[] = $fieldName;
                $errors[$fieldName] = new Error($rule->getMessage(), $validator->getMetadata());
            }
        }
    }

    private function getFieldValue($fieldName, $object)
    {
        if ($object instanceof \stdClass) {
            return $object->$fieldName;
        }

        $reflection = new \ReflectionClass(get_class($object));
        try {
            $property = $reflection->getProperty($fieldName);
        }
        catch (\Exception $e) {
            $property = null;
        }

        $value = null;
        $methodName = 'get'.ucfirst($fieldName);

        if ($property && $property->isPublic()) {
            $value = $property->getValue($object);
        }
        elseif ($reflection->hasMethod($methodName)) {
            $value = call_user_func(array($object, $methodName));
        }

        return $value;
    }

    public function getErrors(): array
    {
        return $this->clearEmpty($this->errors);
    }

    private function clearEmpty(array &$data): array
    {
        foreach ($data as $key => $value) {
            if (is_null($value)) {
                unset($data[$key]);
            } elseif (is_array($value)) {
                if (count($value) === 0) {
                    unset($data[$key]);
                } else {
                    if (empty($this->clearEmpty($value))) {
                        unset($data[$key]);
                    }
                }
            }
        }

        return $data;
    }
}
