<?php
namespace Ayeo\Validator\Constraint;

use Ayeo\Validator\CheckNull;

class NotNull extends AbstractConstraint implements CheckNull
{
    public function run($value): bool
    {
        return is_null($value) === false;
    }

    public function getMetadata(): array
    {
        return [];
    }
}
