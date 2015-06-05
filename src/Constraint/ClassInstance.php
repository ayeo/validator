<?php
namespace Ayeo\Validator\Constraint;

use Ayeo\Validator\Exception\InvalidConstraintParameter;

class ClassInstance extends AbstractConstraint
{
    /**
     * @var string
     */
    private $className;

    /**
     * @param $className
     * @throws InvalidConstraintParameter
     */
    public function __construct($className)
    {
        if (is_string($className))
        {
            $this->className = $className;
        }
        else
        {
            throw new InvalidConstraintParameter();
        }
    }

    /**
     * @param $value
     * @return bool
     */
    public function run($value)
    {
        $className = $this->className;

        if (!$value instanceof $className)
        {
            $this->addError('invalid_object_type');
        }
    }
}