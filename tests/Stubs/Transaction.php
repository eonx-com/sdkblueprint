<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs;

use LoyaltyCorp\SdkBlueprint\Sdk\BaseDataTransferObject;

class Transaction extends BaseDataTransferObject
{
    /**
     * @var null|string
     */
    public $amount;

    /**
     * @var null|string
     */
    public $currency;
}
