<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Endpoints;

class BankAccount extends Endpoint
{
    private $bsb;

    /**
     * @return mixed
     */
    public function getBsb()
    {
        return $this->bsb;
    }

    /**
     * @param mixed $bsb
     */
    public function setBsb($bsb): void
    {
        $this->bsb = $bsb;
    }
}
