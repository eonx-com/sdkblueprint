<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers;

use GuzzleHttp\Exception\GuzzleException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

interface ResponseHandlerInterface
{
    /**
     * Handler PSR-7 response.
     *
     * @param \Psr\Http\Message\ResponseInterface $psrResponse
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface
     */
    public function handle(PsrResponseInterface $psrResponse): ResponseInterface;

    /**
     * Handle exception.
     *
     * @param \GuzzleHttp\Exception\GuzzleException $exception
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface
     */
    public function handleException(GuzzleException $exception): ResponseInterface;
}
