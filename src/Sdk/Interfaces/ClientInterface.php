<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces;

interface ClientInterface
{
    /**
     * Send a HTTP request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestInterface $request
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface
     */
    public function request(RequestInterface $request): ResponseInterface;
}
