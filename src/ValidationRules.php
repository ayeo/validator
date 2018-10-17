<?php
namespace Ayeo\Validator;

abstract class ValidationRules
{
	/**
	 * @return Rule[]
	 */
	abstract function getRules();

    public function getDefaultValue(string $key)
    {
        $rules = $this->getRules();
        if (isset($rules[$key][2]))
        {
            return $rules[$key][2];
        }
        else
        {
            return null;
        }
    }
}
