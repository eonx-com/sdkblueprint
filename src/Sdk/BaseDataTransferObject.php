<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use EoneoPay\Externals\ORM\Entity;
use EoneoPay\Utils\Str;

class BaseDataTransferObject extends Entity
{
    public function __get($property)
    {
        return $this->$property;
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    /**
     * {@inheritdoc
     */
    public function toArray(): array
    {
        return [];
    }
}
