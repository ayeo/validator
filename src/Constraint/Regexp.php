<?php
namespace Ayeo\Validator\Constraint;

class Regexp extends AbstractConstraint
{
    /** @var string */
    private $pattern;

	/** @var string */
	private $errorMessage;

	public function __construct(string $pattern, string $errorMessage = null)
	{
		$this->pattern = $pattern;
		$this->errorMessage = $errorMessage;
	}

    public function run($value)
    {
        if (preg_match($this->pattern, $value) === false)
        {
            $this->addError($this->errorMessage);
        }
    }
}
