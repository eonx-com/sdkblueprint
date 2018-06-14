<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestSerializationGroupAwareInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestValidationGroupAwareInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @SuppressWarnings(PHPMD.ShortVariable) id is a required attribute name
 * in order to be used by normalization and de-normalization correctly.
 */
class Ewallet implements
    RequestObjectInterface,
    RequestValidationGroupAwareInterface,
    RequestSerializationGroupAwareInterface
{
    /**
     * @Groups({"create", "ewallet_create"})
     *
     * @var null|string
     */
    private $amount;

    /**
     * @var null|string
     */
    private $id;

    /**
     * Instantiate attributes.
     *
     * @param null|string $amount
     * @param null|string $id
     */
    public function __construct(?string $amount = null, ?string $id = null)
    {
        $this->amount = $amount;
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function expectObject(): string
    {
        return self::class;
    }

    /**
     * Get amount.
     *
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get id.
     *
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set amount.
     *
     * @param null|string $amount
     *
     * @return void
     */
    public function setAmount(?string $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * Set id.
     *
     * @param null|string $id
     *
     * @return void
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
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
