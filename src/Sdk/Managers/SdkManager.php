<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Managers;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\RequestHandlerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\SdkManagerInterface;

final class SdkManager implements SdkManagerInterface
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
    public function __construct(RequestHandlerInterface $requestHandler)
    {
        $this->requestHandler = $requestHandler;
    }

    /**
     * @inheritdoc
     */
    public function execute(EntityInterface $entity, string $action, ?string $apikey = null)
    {
        return $this->requestHandler->executeAndRespond($entity, $action, $apikey);
    }
}
