<?php
namespace Ayeo\Validator;

class Error
{
    /** @var string */
    public $message;
    /** @var array */
    private $metadata;
    /** @var null|string */
    private $code;

    public function __construct(string $message, array $metadata, ?string $code = null)
    {
        $this->message = $message;
        $this->metadata = $metadata;
        $this->code = $code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function __toString(): string
    {
        return $this->getMessage();
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

