<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface RequestObjectInterface
{
    public function expectObject(): ?string;

    public function getUris(): array;
}