<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface;

class Response implements ResponseInterface
{
    private $code;
    private $message;
    private $content;
    private $statusCode;

    public function __construct(
        int $statusCode,
        ?array $content = null,
        ?string $code = null,
        ?string $message = null
    ) {
        $this->statusCode = $statusCode;
        $this->content = $content;
        $this->code = $code;
        $this->message = $message;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }
}
