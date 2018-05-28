<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestInterface;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\DataTransferObjectStub;

class ValidRequestExpectException extends DataTransferObjectStub implements RequestInterface
{
    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUri(): string
    {
        return 'uri';
    }

    public function getOptions(): array
    {
        return [];
    }
}
