<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

use LoyaltyCorp\SdkBlueprint\Sdk\Command;

interface ClientInterface
{
    /**
     * Send a HTTP request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\CommandInterface $command
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\SdkResponseInterface
     */
    public function request(CommandInterface $command): SdkResponseInterface;
}
