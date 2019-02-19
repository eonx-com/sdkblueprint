<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;

interface RequestHandlerInterface
{
    /**
     * The delete method.
     *
     * @var string
     */
    public const DELETE = 'delete';
    /**
     * The get method.
     *
     * @var string
     */
    public const GET = 'get';
    /**
     * The list method.
     *
     * @var string
     */
    public const LIST = 'list';
    /**
     * The create method.
     *
     * @var string
     */
    public const POST = 'post';
    /**
     * The update method.
     *
     * @var string
     */
    public const PUT = 'put';

    /**
     * Make a DELETE request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string $uri
     * @param array|null $options
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\BaseException
     */
    public function delete(EntityInterface $entity, string $uri, ?array $options = null): void;

    /**
     * Make a GET request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string $uri
     * @param array|null $options
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     *
     * @throws \EoneoPay\Utils\Exceptions\BaseException
     */
    public function get(EntityInterface $entity, string $uri, ?array $options = null): EntityInterface;

    /**
     * Make a GET (LIST) request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string $uri
     * @param array|null $options
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface[]
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function list(EntityInterface $entity, string $uri, ?array $options = null): array;

    /**
     * Make a POST request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string $uri
     * @param array|null $options
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     *
     * @throws \EoneoPay\Utils\Exceptions\BaseException
     */
    public function post(EntityInterface $entity, string $uri, ?array $options = null): EntityInterface;

    /**
     * Make a PUT request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string $uri
     * @param array|null $options
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     *
     * @throws \EoneoPay\Utils\Exceptions\BaseException
     */
    public function put(EntityInterface $entity, string $uri, ?array $options = null): EntityInterface;
}
