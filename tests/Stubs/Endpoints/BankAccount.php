<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Endpoints;

class BankAccount extends Endpoint
{
    /**
     * The bsb,
     *
     * @var null|string
     */
    private $bsb;

    /**
     * Get bsb.
     *
     * @return null|string
     */
    public function getBsb(): ?string
    {
        return $this->bsb;
    }

    /**
     * Set bsb.
     *
     * @param mixed $bsb
     *
     * @return void
     */
    public function setBsb(?string $bsb): void
    {
        $this->bsb = $bsb;
    }
}
