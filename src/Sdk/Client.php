<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ClientInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\CommandInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\SdkResponseInterface;

class Client implements ClientInterface
{
    public function request(CommandInterface $requestObject): SdkResponseInterface
    {
        // TODO: Implement request() method.
    }
}
