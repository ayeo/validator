<?php
namespace Ayeo\Validator\Constraint;

class MinLength extends AbstractConstraint
{
    /**
     * @var integer
     */
    private $min;

    /**
     * @param int $min
     */
    public function __construct($min = 0)
    {
        $this->min = $min;
    }

    public function run($value): bool
    {
        if (mb_strlen($value) < $this->min)
        {
            return false;
        }

        return true;
    }

    public function getMetadata(): array
    {
        return [
            'minLength' => $this->min
        ];
    }
}