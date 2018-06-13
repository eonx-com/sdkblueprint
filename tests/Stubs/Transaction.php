<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs;

class Transaction
{
    /**
     * @var null|string
     */
    private $amount;

    /**
     * @var null|string
     */
    private $currency;

    /**
     * Get the amount.
     *
     * @return null|string
     */
    public function getAmount(): ?string
    {
        return $this->amount;
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
     * Get currency.
     *
     * @return null|string
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Set currency.
     *
     * @param null|string $currency
     *
     * @return void
     */
    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }
}
