<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs;

use LoyaltyCorp\SdkBlueprint\Sdk\BaseDataTransferObject;

class Transaction extends BaseDataTransferObject
{
    /**
     * The Amount.
     *
     * @var null|string
     */
    protected $amount;

    /**
     * The currency.
     *
     * @var null|string
     */
    protected $currency;
}
