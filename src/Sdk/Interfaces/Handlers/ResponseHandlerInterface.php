<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers;

use Exception;
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
     * Handle request exception.
     *
     * @param \Exception $exception
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface
     */
    public function handleRequestException(Exception $exception): ResponseInterface;
}
