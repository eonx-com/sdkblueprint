<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Handlers;

use EoneoPay\Utils\XmlConverter;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\ResponseHandlerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Response;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Psr\Http\Message\StreamInterface;
use RuntimeException;

final class ResponseHandler implements ResponseHandlerInterface
{
    /**
     * @inheritdoc
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidXmlException
     */
    public function handle(PsrResponseInterface $psrResponse): ResponseInterface
    {
        $content = $this->getBodyContents($psrResponse->getBody());

        return new Response(
            $this->processResponseContent($content),
            $psrResponse->getStatusCode(),
            $psrResponse->getHeaders(),
            $content
        );
    }

    /**
     * @inheritdoc
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidXmlException
     */
    public function handleException(GuzzleException $exception): ResponseInterface
    {
        if (($exception instanceof RequestException) === true) {
            /**
             * @var \GuzzleHttp\Exception\RequestException $exception
             *
             * @see https://youtrack.jetbrains.com/issue/WI-37859 typehint required until PhpStorm recognises === check
             */
            return $this->handleRequestException($exception);
        }

        // Covers any other guzzle exception, only here for safety so intentionally ignored
        /** @noinspection BadExceptionsProcessingInspection */
        return new Response(null, 500); // @codeCoverageIgnore
    }

    /**
     * Handle request exception.
     *
     * @param \GuzzleHttp\Exception\RequestException $exception
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidXmlException
     */
    private function handleRequestException(RequestException $exception): ResponseInterface
    {
        if ($exception->hasResponse() && $exception->getResponse() !== null) {
            $content = $this->getBodyContents($exception->getResponse()->getBody());

            return new Response(
                $this->processResponseContent($content),
                $exception->getResponse()->getStatusCode(),
                $exception->getResponse()->getHeaders(),
                $content
            );
        }

        $content = \json_encode(['exception' => $exception->getMessage()]) ?: '';

        return new Response($this->processResponseContent($content), 400, null, $content);
    }

    /**
     * Get response body contents.
     *
     * @param \Psr\Http\Message\StreamInterface $body
     *
     * @return string
     */
    private function getBodyContents(StreamInterface $body): string
    {
        try {
            return $body->getContents();
            // This is only here as a sanity check, it will only be thrown if fails to read from Stream
            //@codeCoverageIgnoreStart
        } catch (RuntimeException $exception) {
            return '';
        } //@codeCoverageIgnoreEnd
    }

    /**
     * Determine if a string is json.
     *
     * @param string $string The string to check
     *
     * @return bool
     */
    private function isJson(string $string): bool
    {
        \json_decode($string);

        return \json_last_error() === \JSON_ERROR_NONE;
    }

    /**
     * Determine if a string is xml.
     *
     * @param string $string The string to check
     *
     * @return bool
     */
    private function isXml(string $string): bool
    {
        \libxml_use_internal_errors(true);

        return \simplexml_load_string($string) !== false;
    }

    /**
     * Process response body into an array.
     *
     * @param string $content
     *
     * @return mixed[]|null
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidXmlException
     */
    private function processResponseContent(string $content): ?array
    {
        // If contents is json, decode it
        if ($this->isJson($content) === true) {
            return \json_decode($content, true);
        }

        // If content is xml, decode it
        if ($this->isXml($content) === true) {
            return (new XmlConverter())->xmlToArray($content);
        }

        // Return result as array
        return ['content' => $content];
    }
}
