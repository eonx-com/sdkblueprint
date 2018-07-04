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
     * Execute the create request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \Exception - one of CriticalException, NotFoundException, RuntimeException and ValidationException.
     */
    public function create(RequestObjectInterface $request)
    {
        return $this->execute(new RequestAdapter('POST', RequestMethodInterface::CREATE, $request));
    }

    /**
     * Execute the delete request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \Exception - one of CriticalException, NotFoundException, RuntimeException and ValidationException.
     */
    public function delete(RequestObjectInterface $request)
    {
        return $this->execute(new RequestAdapter('DELETE', RequestMethodInterface::DELETE, $request));
    }

    /**
     * Execute the get request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \Exception - one of CriticalException, NotFoundException, RuntimeException and ValidationException.
     */
    public function get(RequestObjectInterface $request)
    {
        return $this->execute(new RequestAdapter('GET', RequestMethodInterface::GET, $request));
    }

    /**
     * Execute the list request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \Exception - one of CriticalException, NotFoundException, RuntimeException and ValidationException.
     */
    public function list(RequestObjectInterface $request)
    {
        return $this->execute(new RequestAdapter('GET', RequestMethodInterface::LIST, $request));
    }

    /**
     * Execute the update request.
     *
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface $request
     *
     * @return mixed returns the object of the expected class.
     *
     * @throws \Exception - one of CriticalException, NotFoundException, RuntimeException and ValidationException.
     */
    public function update(RequestObjectInterface $request)
    {
        return $this->execute(new RequestAdapter('PUT', RequestMethodInterface::UPDATE, $request));
    }

    /**
     * Execute a request.
     *
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
