<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests;

/**
 * @SuppressWarnings(PHPMD.ShortVariable) id is a required attribute name
 * in order to be used by normalization and de-normalization correctly.
 */
class Ewallet
{
    /**
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
}
