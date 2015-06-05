<?php
namespace Ayeo\Validator\Constraint;

class NotClassInstance extends AbstractConstraint
{
    /**
     * @var string
     */
    private $className;

    public function __construct($className)
    {
        $this->className = $className;
    }

    public function run($value)
    {
        $className = $this->className;

        if ($value instanceof $className)
        {
            $this->addError('must_not_be_instance', $this->className);
        }
    }
}