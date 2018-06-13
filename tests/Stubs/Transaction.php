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
     * @return mixed
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * Set amount.
     *
     * @param mixed $amount
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
     * @return mixed
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Set currency.
     *
     * @param mixed $currency
     *
     * @return void
     */
    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }
}
