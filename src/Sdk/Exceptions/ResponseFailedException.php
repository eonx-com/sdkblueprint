<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use EoneoPay\Utils\Exceptions\BaseException;
use Throwable;

class ResponseFailedException extends BaseException
{
    /**
     * Response status code.
     *
     * @var int $statusCode
     */
    private $statusCode;

    /**
     * Response error sub code.
     *
     * @var null|int $subCode
     */
    private $subCode;

    /**
     * Instantiate attributes.
     *
     * @param null|string $message
     * @param null|int $code
     * @param null|int $statusCode
     * @param null|int $subCode
     * @param null|\Throwable $previous
     */
    public function __construct(
        ?string $message = null,
        ?int $code = null,
        int $statusCode,
        ?int $subCode = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->statusCode = $statusCode;
        $this->subCode = $subCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorCode(): int
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorSubCode(): int
    {
        return $this->subCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
