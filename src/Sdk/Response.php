<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface;

class Response implements ResponseInterface
{
    /**
     * Response code.
     *
     * @var null|string
     */
    private $code;

    /**
     * Response error message.
     *
     * @var null|string
     */
    private $message;

    /**
     * Response contents.
     *
     * @var null|mixed[]
     */
    private $content;

    /**
     * Response status code.
     *
     * @var int
     */
    private $statusCode;

    /**
     * Instantiate the object.
     *
     * @param int $statusCode
     * @param null|mixed[] $content
     * @param null|string $code
     * @param null|string $message
     */
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

    /**
     * Get the error code.
     *
     * @return null|string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Get the successful response content.
     *
     * @return null|mixed[]
     */
    public function getContent(): ?array
    {
        return $this->content;
    }

    /**
     * Get the error message.
     *
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * Get the status code.
     *
     * @return null|int
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }
}
