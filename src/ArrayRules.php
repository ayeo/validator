<?php
namespace Ayeo\Validator;

class ArrayRules extends ValidationRules
{
    private $rules;

    public function __construct(array $array)
    {
        $this->rules = $array;
    }

    /**
     * @return array
     */
    function getRules()
    {
        return $this->rules;
    }

}