<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;

interface RequestHandlerInterface
{
    /**
     * Make a DELETE request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string $uri
     * @param array|null $options
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     *
     * @throws \EoneoPay\Utils\Exceptions\BaseException
     */
    public function delete(EntityInterface $entity, string $uri, ?array $options = null): EntityInterface;

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
}
