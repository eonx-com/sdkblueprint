<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Handlers;

use Exception;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\ResponseHandlerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Response;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class ResponseHandlerStub implements ResponseHandlerInterface
{
    /**
     * @inheritdoc
     */
    public function handle(PsrResponseInterface $psrResponse): ResponseInterface
    {
        $content = $psrResponse->getBody()->getContents();

        return new Response(
            \json_decode($content, true),
            $psrResponse->getStatusCode(),
            $psrResponse->getHeaders(),
            $content
        );
    }

    /**
     * @inheritdoc
     */
    public function handleRequestException(Exception $exception): ResponseInterface
    {
        return new Response(
            [],
            $exception->getCode(),
            [],
            $exception->getMessage()
        );
    }
}
