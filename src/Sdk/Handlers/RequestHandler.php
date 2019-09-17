<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Handlers;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidApiResponseException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidUriActionException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Factories\SerializerFactoryInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Factories\UrnFactoryInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\RequestHandlerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\ResponseHandlerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\SerializationGroupAwareInterface;

final class RequestHandler implements RequestHandlerInterface
{
    /**
     * Guzzle http client.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    private $httpClient;

    /**
     * Response handler.
     *
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\ResponseHandlerInterface
     */
    private $responseHandler;

    /**
     * Symfony serializer.
     *
     * @var \Symfony\Component\Serializer\Serializer
     */
    private $serializer;

    /**
     * Urn factory instance.
     *
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Factories\UrnFactoryInterface
     */
    private $urnFactory;

    /**
     * Construct request handler.
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\ResponseHandlerInterface $responseHandler
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Factories\SerializerFactoryInterface $serializerFactory
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Factories\UrnFactoryInterface $urnFactory
     */
    public function __construct(
        GuzzleClientInterface $client,
        ResponseHandlerInterface $responseHandler,
        SerializerFactoryInterface $serializerFactory,
        UrnFactoryInterface $urnFactory
    ) {
        $this->responseHandler = $responseHandler;
        $this->httpClient = $client;
        $this->serializer = $serializerFactory->create();
        $this->urnFactory = $urnFactory;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidApiResponseException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidUriActionException
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function executeAndRespond(
        EntityInterface $entity,
        string $action,
        ?string $apikey = null
    ) {
        $options = [];

        if ($apikey !== null) {
            $options = \array_merge($options, [
                'auth' => [$apikey, null],
            ]);
        }

        // ensure that the requested action exists
        $entityUris = $entity->uris();
        if (\array_key_exists($action, $entityUris) === false) {
            throw new InvalidUriActionException(
                \sprintf('The URI action (%s) is invalid, or not supported for the specified resource.', $action)
            );
        }

        // get endpoint uri based on request method
        $urn = $this->urnFactory->create($entityUris[$action]);

        $response = $this->execute($action, $urn, $this->getBody($entity, $action, $options));

        if ($response->getStatusCode() === 204) {
            return null;
        }

        $type = \mb_strtolower($action) === self::LIST ?
            \sprintf('%s[]', \get_class($entity)) : \get_class($entity);

        return $this->serializer->deserialize($response->getContent(), $type, 'json');
    }

    /**
     * Execute a request.
     *
     * @param string $action Request action
     * @param string $uri Request uri path
     * @param mixed[]|null $body Request body
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidApiResponseException
     */
    private function execute(string $action, string $uri, ?array $body = null): ResponseInterface
    {
        try {
            $request = $this->httpClient->request($this->getRequestMethod($action), $uri, $body ?? []);
            // handle response
            $response = $this->responseHandler->handle($request);
        } catch (GuzzleException $exception) {
            $response = $this->responseHandler->handleException($exception);
        }

        // If response is unsuccessful, throw exception
        if ($response->isSuccessful() === false) {
            throw new InvalidApiResponseException($response, $exception ?? null);
        }

        return $response;
    }

    /**
     * Get request method.
     *
     * @param string $action Request action
     *
     * @return string
     */
    private function getRequestMethod(string $action): string
    {
        switch (true) {
            case \mb_strtolower($action) === self::CREATE:
                $method = 'POST';

                break;

            case \mb_strtolower($action) === self::DELETE:
                $method = 'DELETE';

                break;

            case \mb_strtolower($action) === self::UPDATE:
                $method = 'PUT';

                break;

            default:
                $method = 'GET';

                break;
        }

        return $method;
    }

    /**
     * Generate the http body.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string $action
     * @param mixed[]|null $options
     *
     * @return mixed[]
     *
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    private function getBody(EntityInterface $entity, string $action, ?array $options = null): array
    {
        $normalize = $this->serializer->normalize($entity, null, [
            'groups' => $this->getSerializationGroups($entity, $action),
        ]);

        return \array_merge([
            'json' => \is_array($normalize) === true ? $this->getFilterOptions($normalize) : [$normalize],
        ], $options ?? []);
    }

    /**
     * Get serialization group.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string $action
     *
     * @return string[]
     */
    private function getSerializationGroups(EntityInterface $entity, string $action): array
    {
        if (($entity instanceof SerializationGroupAwareInterface) === false) {
            return [$action];
        }

        /**
         * @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\SerializationGroupAwareInterface $entity
         *
         * @see https://youtrack.jetbrains.com/issue/WI-37859 - typehint required until PhpStorm recognises === check
         */
        $groups = $entity->serializationGroups();

        if (isset($groups[$action]) === false) {
            return [$action];
        }

        return $groups[$action];
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
