<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Exceptions;

use EoneoPay\Utils\Exceptions\RuntimeException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface;
use Throwable;

class InvalidApiResponseException extends RuntimeException
{
    /**
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface
     */
    private $response;

    /**
     * InvalidApiResponseException constructor.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface $response The response received from the api
     * @param \Throwable|null $previous The original exception thrown
     */
    public function __construct(ResponseInterface $response, ?Throwable $previous = null)
    {
        parent::__construct('', 0, $previous);

        $this->response = $response;
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorCode(): int
    {
        return self::DEFAULT_ERROR_CODE_RUNTIME;
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorSubCode(): int
    {
        return 1;
    }

    /**
     * Get response.
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
