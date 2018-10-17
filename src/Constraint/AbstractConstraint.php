<?php
namespace Ayeo\Validator\Constraint;

use Ayeo\Validator\CheckNull;

abstract class AbstractConstraint
{
	final public function validate($value): bool
	{
        if (is_null($value)) {
            if ($this instanceof CheckNull === false) {
                return true;
            }
        };

        return $this->run($value);
	}

	abstract public function run($value): bool;

	public function getMetadata(): array
    {
        return [];
    }
}
