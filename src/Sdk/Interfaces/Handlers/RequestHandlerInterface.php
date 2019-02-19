<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestAwareInterface;

interface RequestHandlerInterface extends RequestAwareInterface
{
    /**
     * Make a DELETE request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string|null $apikey Api key
     *
     * @return void
     */
    public function delete(EntityInterface $entity, ?string $apikey = null): void;

    /**
     * Make a GET request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string|null $apikey Api key
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    public function get(EntityInterface $entity, ?string $apikey = null): EntityInterface;

    /**
     * Make a GET (LIST) request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string|null $apikey Api key
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface[]
     */
    public function list(EntityInterface $entity, ?string $apikey = null): array;

    /**
     * Make a POST request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string|null $apikey Api key
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    public function post(EntityInterface $entity, ?string $apikey = null): EntityInterface;

    /**
     * Make a PUT request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface $entity
     * @param string|null $apikey Api key
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface
     */
    public function put(EntityInterface $entity, ?string $apikey = null): EntityInterface;
}
