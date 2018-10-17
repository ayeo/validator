<?php


namespace Ayeo\Validator;

class MultiRule
{
    /** @var Rule[] */
    private $rules;

    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @return Rule[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }
}
