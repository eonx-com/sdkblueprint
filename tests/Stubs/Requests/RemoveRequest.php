<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests;

use LoyaltyCorp\SdkBlueprint\Sdk\BaseDataTransferObject;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodAwareInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestSerializationGroupAwareInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestValidationGroupAwareInterface;

class RemoveRequest extends BaseDataTransferObject implements
    RequestMethodAwareInterface,
    RequestObjectInterface,
    RequestValidationGroupAwareInterface,
    RequestSerializationGroupAwareInterface
{
    /**
     * @inheritdoc
     */
    public function expectObject(): ?string
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function uris(): array
    {
        return [
            self::DELETE => 'delete_uri'
        ];
    }

    /**
     * @inheritdoc
     */
    public function serializationGroup(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function validationGroups(): array
    {
        return [];
    }
}
