<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Entities;

use LoyaltyCorp\SdkBlueprint\Sdk\Entity;

class EwalletStub extends Entity
{
    /**
     * @inheritdoc
     */
    public function getUris(): array
    {
        return [];
    }
}
