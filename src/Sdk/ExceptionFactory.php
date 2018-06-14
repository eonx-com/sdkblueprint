<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\CriticalException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\NotFoundException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\RuntimeException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException;

class ExceptionFactory
{
    /**
     * The error code.
     *
     * @var int|null
     */
    private $code;

    /**
     * The error message.
     *
     * @var null|string
     */
    private $message;

    /**
     * Initialize attributes.
     *
     * @param null|string $message
     * @param null|int $code
     */
    public function __construct(?string $message = null, ?int $code = null)
    {
        $this->message = $message;
        $this->code = $code;
    }

    /**
     * Create exception object based on error code range.
     *
     * @return \Exception
     */
    public function create(): \Exception
    {
        if (($this->code >= 1000) && ($this->code <= 1099)) {
            return new ValidationException($this->message, $this->code);
        }

        if ($this->code >= 1100 && $this->code <= 1199) {
            return new RuntimeException($this->message, $this->code);
        }

        if ($this->code >= 1400 && $this->code <= 1499) {
            return new NotFoundException($this->message, $this->code);
        }

        return new CriticalException($this->message, $this->code);
    }
}
