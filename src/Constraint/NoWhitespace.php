<?php
namespace Ayeo\Validator\Constraint;

class NoWhitespace extends AbstractConstraint
{
	public function run($value)
	{
		$parsed = preg_replace('/\s+/', '', $value);
		if ($parsed !== $value)
		{
			$this->addError('must_not_contains_whitespace');
		}
	}
}