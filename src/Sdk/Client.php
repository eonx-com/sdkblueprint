<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException;
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
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException
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
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException
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
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException
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
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException
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
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException
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
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute(RequestAdapter $request)
    {
        $request->validate();

        $response = $this->request($request);

        if ($response->isSuccessful() === false) {
            throw new ResponseFailedException(
                $response->getMessage(),
                $response->getCode(),
                $response->getStatusCode()
            );
        }

        return $request->getObject($response->getContents());
    }
}
