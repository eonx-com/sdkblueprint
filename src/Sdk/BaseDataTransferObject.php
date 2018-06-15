<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use EoneoPay\Externals\ORM\Entity;

class BaseDataTransferObject extends Entity
{
    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [];
    }
}
