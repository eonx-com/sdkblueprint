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
     * @param RequestObjectInterface $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
     * @throws ResponseFailedException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(RequestObjectInterface $request)
    {
        return $this->execute(new RequestAdapter('POST', RequestMethodInterface::CREATE, $request));
    }

    /**
     * @param RequestObjectInterface $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
     * @throws ResponseFailedException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(RequestObjectInterface $request)
    {
        return $this->execute(new RequestAdapter('DELETE', RequestMethodInterface::DELETE, $request));
    }

    /**
     * @param RequestObjectInterface $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
     * @throws ResponseFailedException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(RequestObjectInterface $request)
    {
        return $this->execute(new RequestAdapter('GET', RequestMethodInterface::GET, $request));
    }

    /**
     * @param RequestObjectInterface $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
     * @throws ResponseFailedException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list(RequestObjectInterface $request)
    {
        return $this->execute(new RequestAdapter('GET', RequestMethodInterface::LIST, $request));
    }

    /**
     * @param RequestObjectInterface $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
     * @throws ResponseFailedException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(RequestObjectInterface $request)
    {
        return $this->execute(new RequestAdapter('PUT', RequestMethodInterface::UPDATE, $request));
    }

    /**
     * @param RequestAdapter $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
     * @throws ResponseFailedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute(RequestAdapter $request)
    {
        $request->validate();

        $response = $this->request($request);

        if ($response->isSuccessful() === false) {
            throw new ResponseFailedException($response->getMessage());
        }

        return $request->getObject($response->getContents());
    }
}
