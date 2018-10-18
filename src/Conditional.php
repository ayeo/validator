<?php

namespace Ayeo\Validator;

class Conditional
{
    /** @var string */
    private $dependsOn;
    /** @var string */
    private $conditionalValue;
    /** @var array */
    private $rules;

    public function __construct(string $dependsOn, string $conditionalValue, array $rules)
    {
        $this->dependsOn = $dependsOn;
        $this->conditionalValue = $conditionalValue;
        $this->rules = $rules;
    }

    public function getFieldName(): string
    {
        return $this->dependsOn;
    }

    public function getExpectedValue(): string
    {
        return $this->conditionalValue;
    }

    public function getRules(): array
    {
        return $this->rules;
    }
}
