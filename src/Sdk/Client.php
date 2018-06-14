<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;
use LoyaltyCorp\SdkSpecification\Client as BaseClient;

class Client extends BaseClient
{
    /**
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException;
     * @throws \Exception - one of CriticalException, NotFoundException, RuntimeException and ValidationException.
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(RequestObjectInterface $request)
    {
        return $this->execute(new RequestAdapter('POST', RequestMethodInterface::CREATE, $request));
    }

    /**
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException;
     * @throws \Exception - one of CriticalException, NotFoundException, RuntimeException and ValidationException.
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(RequestObjectInterface $request)
    {
        return $this->execute(new RequestAdapter('DELETE', RequestMethodInterface::DELETE, $request));
    }

    /**
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException;
     * @throws \Exception - one of CriticalException, NotFoundException, RuntimeException and ValidationException.
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(RequestObjectInterface $request)
    {
        return $this->execute(new RequestAdapter('GET', RequestMethodInterface::GET, $request));
    }

    /**
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException;
     * @throws \Exception - one of CriticalException, NotFoundException, RuntimeException and ValidationException.
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list(RequestObjectInterface $request)
    {
        return $this->execute(new RequestAdapter('GET', RequestMethodInterface::LIST, $request));
    }

    /**
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException;
     * @throws \Exception - one of CriticalException, NotFoundException, RuntimeException and ValidationException.
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(RequestObjectInterface $request)
    {
        return $this->execute(new RequestAdapter('PUT', RequestMethodInterface::UPDATE, $request));
    }

    /**
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\RequestAdapter $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \Exception - one of CriticalException, NotFoundException, RuntimeException and ValidationException.
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute(RequestAdapter $request)
    {
        $request->validate();

        $response = $this->request($request);

        if ($response->isSuccessful() === false) {
            throw (new ExceptionFactory($response->getMessage(), $response->getCode()))->create();
        }

        return $request->getObject($response->getContents());
    }
}
