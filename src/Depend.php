<?php

namespace Ayeo\Validator;

class Depend
{
    /** @var Zbychu[] */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return Zbychu[]
     */
    public function getZbychus(): array
    {
        return $this->data;
    }
}
