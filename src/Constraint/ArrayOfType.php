<?php

namespace Ayeo\Validator\Constraint;

class ArrayOfType extends IsArray
{
    /** @var string  */
    private $type;

    /**
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    public function run($value)
    {
        parent::run($value);

        if ($this->hasError()) {
            return;
        }

        foreach ($value as $key => $single) {
            if (gettype($single) !== $this->type) {
                $this->addError(sprintf('Given array contains %s at index %s', gettype($single), $key));

                return;
            }
        }
    }
}
