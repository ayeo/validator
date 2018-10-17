<?php
namespace Ayeo\Validator\Constraint;

class OneOf extends AbstractConstraint
{
    public function __construct(array $allowedValues)
    {
        $this->allowedValues = $allowedValues;
    }

    public function run($value): bool
    {
        if (in_array($value, $this->allowedValues) === false) {
            return false;
        }

        return true;
    }

    public function getMetadata(): array
    {
        return ['allowedValues' => $this->allowedValues];
    }
}
