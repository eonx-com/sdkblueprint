<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use EoneoPay\Externals\ORM\Entity;

class BaseDataTransferObject extends Entity
{
    /**
     * Magic getter for serializer to access protected attribute.
     *
     * @param mixed $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        return $this->$property;
    }

    /**
     * Magic getter for serializer to set value for protected attribute.
     *
     * @param mixed $property
     * @param mixed $value
     *
     * @return void
     */
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
