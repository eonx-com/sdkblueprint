<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk\Managers;

use Doctrine\Common\Annotations\AnnotationReader;
use LoyaltyCorp\SdkBlueprint\Sdk\Annotations\Repository as RepositoryAnnotation;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ApiManagerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\EntityInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\Handlers\RequestHandlerInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RepositoryInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Repository;

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
    public function __construct(RequestHandlerInterface $requestHandler)
    {
        $this->requestHandler = $requestHandler;
    }

    /**
     * @inheritdoc
     */
    public function create(EntityInterface $entity): EntityInterface
    {
        return $this->requestHandler->post($entity, 'api-key');
    }

    /**
     * @inheritdoc
     */
    public function delete(EntityInterface $entity): bool
    {
        return $this->requestHandler->delete($entity, 'api-key');
    }

    /**
     * @inheritdoc
     */
    public function find(string $entityName, string $entityId): EntityInterface
    {
        $class = new $entityName(['id' => $entityId]);

        return $this->requestHandler->get($class, 'api-key');
    }

    /**
     * @inheritdoc
     */
    public function findAll(string $entityName): array
    {
        return $this->requestHandler->list(new $entityName(), 'api-key');
    }

    /**
     * @inheritdoc
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
     */
    public function getRepository(string $entityClass): RepositoryInterface
    {
        $reflectionClass = new \ReflectionClass($entityClass);
        $classAnnotations = (new AnnotationReader())->getClassAnnotations($reflectionClass);

        foreach ($classAnnotations as $annotation) {
            if (($annotation instanceof RepositoryAnnotation) === true) {
                return new $annotation->repositoryClass($this, $entityClass);
            }
        }

        return new Repository($this, $entityClass);
    }

    /**
     * @inheritdoc
     */
    public function update(EntityInterface $entity): EntityInterface
    {
        return $this->requestHandler->put($entity, 'api-key');
    }
}
