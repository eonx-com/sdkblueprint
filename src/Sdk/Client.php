<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use EoneoPay\Externals\HttpClient\Client as BaseClient;
use EoneoPay\Externals\HttpClient\Exceptions\InvalidApiResponseException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;

class Client extends BaseClient
{
    /**
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \Exception - one of CriticalException, NotFoundException, RuntimeException and ValidationException.
     * @throws \Doctrine\Common\Annotations\AnnotationException
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
     * @throws \Exception - one of CriticalException, NotFoundException, RuntimeException and ValidationException.
     * @throws \Doctrine\Common\Annotations\AnnotationException
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
     * @throws \Exception - one of CriticalException, NotFoundException, RuntimeException and ValidationException.
     * @throws \Doctrine\Common\Annotations\AnnotationException
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
     * @throws \Exception - one of CriticalException, NotFoundException, RuntimeException and ValidationException.
     * @throws \Doctrine\Common\Annotations\AnnotationException
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
     * @throws \Exception - one of CriticalException, NotFoundException, RuntimeException and ValidationException.
     * @throws \Doctrine\Common\Annotations\AnnotationException
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
     */
    public function execute(RequestAdapter $request)
    {
        $request->validate();

        try {
            $response = $this->request($request->method(), $request->uri(), $request->options());
        } catch (InvalidApiResponseException $exception) {
            throw (new ExceptionFactory($exception))->create();
        }

        return $request->getObject($response->getContent());
    }
}
