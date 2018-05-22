<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface ClientInterface
{
    /**
     * Send a HTTP request.
     *
     * @param CommandInterface $requestObject
     *
     * @return SdkResponseInterface
     */
    public function request(CommandInterface $requestObject): SdkResponseInterface;
}
