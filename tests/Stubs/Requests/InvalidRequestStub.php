<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestInterface;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\DataTransferObjectStub;

class InvalidRequestStub extends DataTransferObjectStub implements RequestInterface
{
    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return 'get';
    }

    /**
     * {@inheritdoc}
     */
    public function getUri(): string
    {
        return 'uri';
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions(): array
    {
        return [];
    }
}
