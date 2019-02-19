<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ApiManagerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\RequestHandlerInterface;

final class ApiManager implements ApiManagerInterface
{
    /**
     * Request handler.
     *
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\RequestHandlerInterface
     */
    private $requestHandler;

    /**
     * Construct sdk api manager
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\RequestHandlerInterface $requestHandler
     */
    public function __construct(
        RequestHandlerInterface $requestHandler
    ) {
        $this->requestHandler = $requestHandler;
    }

    /**
     * @inheritdoc
     *
     * @throws \EoneoPay\Utils\Exceptions\BaseException
     */
    public function create(EntityInterface $entity): EntityInterface
    {
        return $this->requestHandler->post($entity, 'http://localhost/', [
            'auth' => 'api-key'
        ]);
    }

    /**
     * @inheritdoc
     *
     * @throws \EoneoPay\Utils\Exceptions\BaseException
     */
    public function delete(EntityInterface $entity): EntityInterface
    {
        return $this->requestHandler->delete($entity, 'http://localhost/', [
            'auth' => 'api-key'
        ]);
    }

    /**
     * @inheritdoc
     *
     * @throws \EoneoPay\Utils\Exceptions\BaseException
     */
    public function find(EntityInterface $entity): EntityInterface
    {
        return $this->requestHandler->get($entity, 'http://localhost/', [
            'auth' => 'api-key'
        ]);
    }

    /**
     * @inheritdoc
     *
     * @throws \EoneoPay\Utils\Exceptions\BaseException
     */
    public function update(EntityInterface $entity): EntityInterface
    {
        return $this->requestHandler->put($entity, 'http://localhost/', [
            'auth' => 'api-key'
        ]);
    }
}
