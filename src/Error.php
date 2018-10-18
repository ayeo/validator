<?php
namespace Ayeo\Validator;

class Error
{
    //fixme: use toArray instead public props
    /** @var string */
    public $message;
    /** @var array */
    public $metadata;
    /** @var null|string */
    public $code;

    public function __construct(string $message, array $metadata, ?string $code = '')
    {
        $this->message = $message;
        $this->metadata = $metadata;
        $this->code = $code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }
}

