<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs;

use LoyaltyCorp\SdkBlueprint\Sdk\BaseDataTransferObject;

class Transaction extends BaseDataTransferObject
{
    /**
     * @var null|string
     */
    protected $amount;

    /**
     * @var null|string
     */
    protected $currency;
}
