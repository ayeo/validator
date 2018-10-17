<?php

namespace Ayeo\Validator;

class Rule
{
    /** @var Constraint\AbstractConstraint */
    private $constraint;
    /** @var string */
    private $message;
    /** @var null|string */
    private $errorCode;

    public function __construct(Constraint\AbstractConstraint $constraint, string $message, ?string $errorCode = null)
    {
        $this->constraint = $constraint;
        $this->message = $message;
        $this->errorCode = $errorCode;
    }

    public function getConstraint(): Constraint\AbstractConstraint
    {
        return $this->constraint;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCode(): string
    {
        return $this->errorCode ?? '';
    }
}
