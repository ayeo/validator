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
	$result = preg_match($this->pattern, $value);
        if ($result === false || $result === 0)
        {
            $this->addError($this->errorMessage);
        }
    }
}
