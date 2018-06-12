<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

class ExceptionFactory
{
    private $code;

    public function __construct(?string $code)
    {
        $this->code = $code;
    }

    public function create()
    {
    }
}
