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
    public function create(string $apikey, EntityInterface $entity): EntityInterface
    {
        return $this->requestHandler->post($entity, $apikey);
    }

    /**
     * @inheritdoc
     */
    public function delete(string $apikey, EntityInterface $entity): bool
    {
        return $this->requestHandler->delete($entity, $apikey);
    }

    /**
     * @inheritdoc
     */
    public function find(string $entityName, string $entityId, string $apikey): EntityInterface
    {
        $class = new $entityName(['id' => $entityId]);

        return $this->requestHandler->get($class, $apikey);
    }

    /**
     * @inheritdoc
     */
    public function findAll(string $entityName, string $apikey): array
    {
        return $this->requestHandler->list(new $entityName(), $apikey);
    }

    /**
     * @inheritdoc
     */
    public function findBy(string $entityName, array $criteria, string $apikey): array
    {
        $class = new $entityName($criteria);

        return $this->requestHandler->list($class, $apikey);
    }

    /**
     * @inheritdoc
     */
    public function findOneBy(string $entityName, array $criteria, string $apikey): EntityInterface
    {
        $class = new $entityName($criteria);

        return $this->requestHandler->get($class, $apikey);
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
    public function update(string $apikey, EntityInterface $entity): EntityInterface
    {
        return $this->requestHandler->put($entity, $apikey);
    }
}
