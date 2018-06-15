<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests;

use LoyaltyCorp\SdkBlueprint\Sdk\BaseDataTransferObject;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestSerializationGroupAwareInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestValidationGroupAwareInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @SuppressWarnings(PHPMD.ShortVariable) id is a required attribute name
 * in order to be used by normalization and de-normalization correctly.
 *
 * @method null|string getAmount()
 * @method null|string getId()
 * @method self setAmount(?string $amount)
 * @method self setId(?string $id)
 */
class Ewallet extends BaseDataTransferObject implements
    RequestObjectInterface,
    RequestValidationGroupAwareInterface,
    RequestSerializationGroupAwareInterface
{
    /**
     * @Groups({"create", "ewallet_create"})
     *
     * @var null|string
     */
    public $amount;

    /**
     * @var null|string
     */
    public $id;

    /**
     * {@inheritdoc}
     */
    public function expectObject(): string
    {
        return self::class;
    }

    /**
     * {@inheritdoc}
     */
    public function serializationGroup(): array
    {
        return [
            RequestMethodInterface::CREATE => ['ewallet_create']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function uris(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function validationGroups(): array
    {
        return [
            RequestMethodInterface::CREATE => ['ewallet_create']
        ];
    }
}
