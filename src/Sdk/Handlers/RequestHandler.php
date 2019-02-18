<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Handlers;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Factories\SerializerFactoryInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;

final class RequestHandler implements RequestHandlerInterface
{
    /**
     * Guzzle http client.
     *
     * @var \GuzzleHttp\ClientInterface|null
     */
    private $httpClient;

    /**
     * Symfony serializer.
     *
     * @var \Symfony\Component\Serializer\Serializer
     */
    private $serializer;

    /**
     * Construct request handler.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Factories\SerializerFactoryInterface $serializerFactory
     * @param \GuzzleHttp\ClientInterface|null $client
     */
    public function __construct(
        GuzzleClientInterface $client,
        SerializerFactoryInterface $serializerFactory
    ) {
        $this->httpClient = $client;
        $this->serializer = $serializerFactory->create();
    }

    /**
     * Make a DELETE request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string $uri
     * @param array|null $options
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function delete(EntityInterface $entity, string $uri, ?array $options = null): EntityInterface
    {
        return $this->executeAndRespond($entity, 'DELETE', $uri, $options);
    }

    /**
     * Make a GET request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string $uri
     * @param array|null $options
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function get(EntityInterface $entity, string $uri, ?array $options = null): EntityInterface
    {
        return $this->executeAndRespond($entity, 'GET', $uri, $options);
    }

    /**
     * Make a POST request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string $uri
     * @param array|null $options
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function post(EntityInterface $entity, string $uri, ?array $options = null): EntityInterface
    {
        return $this->executeAndRespond($entity, 'POST', $uri, $options);
    }

    /**
     * Make a PUT request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string $uri
     * @param array|null $options
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function put(EntityInterface $entity, string $uri, ?array $options = null): EntityInterface
    {
        return $this->executeAndRespond($entity, 'PUT', $uri, $options);
    }

    /**
     * Execute request.
     *
     * @param string $method Request method
     * @param string $uri Uri
     * @param array|null $body Request body
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function execute(string $method, string $uri, ?array $body = null): ResponseInterface
    {
        return $this->httpClient->request($method, $uri, $body ?? []);
    }

    /**
     * Execute request and respond.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string $method
     * @param string $uri
     * @param array|null $options
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    private function executeAndRespond(
        EntityInterface $entity,
        string $method,
        string $uri,
        ?array $options = null
    ): EntityInterface {
        $response = $this->execute($method, $uri, $this->getBody($entity, $method, $options));

        $expectObjectClass = \get_class($entity);

        $type = \mb_strtolower($method) === 'get' ?
            \sprintf('%s[]', $expectObjectClass) : $expectObjectClass;

        return $this->serializer->deserialize($response->getBody()->getContents(), $type, 'json');
    }

    /**
     * Generate the http body.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string $group
     * @param mixed[]|null $options
     *
     * @return mixed[]
     *
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    private function getBody(EntityInterface $entity, string $group, ?array $options = null): array
    {
        $normalize = $this->serializer->normalize($entity, null, ['groups' => [$group]]);

        return \array_merge([
            'json' => $this->getFilterOptions($normalize)
        ], $options ?? []);
    }

    /**
     * Recursively filter options array, remove key value pairs when value is null.
     *
     * @param mixed[] $options
     *
     * @return mixed[]
     */
    private function getFilterOptions(array $options): array
    {
        $original = $options;

        $data = \array_filter($options);

        $data = \array_map(function ($element) {
            return \is_array($element) ? $this->getFilterOptions($element) : $element;
        }, $data);

        return $original === $data ? $data : $this->getFilterOptions($data);
    }
}
