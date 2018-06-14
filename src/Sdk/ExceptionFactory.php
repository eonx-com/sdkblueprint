<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use EoneoPay\Externals\HttpClient\Exceptions\InvalidApiResponseException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\CriticalException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\NotFoundException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\RuntimeException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException;

class ExceptionFactory
{
    /**
     * The error code.
     *
     * @var \EoneoPay\Externals\HttpClient\Exceptions\InvalidApiResponseException
     */
    private $exception;

    /**
     * Initialize the attribute.
     *
     * @param \EoneoPay\Externals\HttpClient\Exceptions\InvalidApiResponseException $exception
     */
    public function __construct(InvalidApiResponseException $exception)
    {
        $this->exception = $exception;
    }

    /**
     * Create exception object based on error code range.
     *
     * @return \Exception
     */
    public function create(): \Exception
    {
        $content = \json_decode($this->exception->getResponse()->getContent(), true);

        $code = $content['code'] ?? $this->exception->getCode();

        $message = $content['message'] ?? $content['exception'] ?? '';

        if (($code >= 1000) && ($code <= 1099)) {
            return new ValidationException($message, $code);
        }

        if ($code >= 1100 && $code <= 1199) {
            return new RuntimeException($message, $code);
        }

        if ($code >= 1400 && $code <= 1499) {
            return new NotFoundException($message, $code);
        }

        return new CriticalException($message, $code);
    }
}
