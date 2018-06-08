<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestUriException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;
use LoyaltyCorp\SdkSpecification\Client as BaseClient;
use LoyaltyCorp\SdkSpecification\Interfaces\ResponseInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Client extends BaseClient
{
    /**
     * Guzzle HTTP client for requests
     *
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var \Symfony\Component\Serializer\Serializer $serializer
     */
    private $serializer;

    /**
     * Validator.
     *
     * @var null|\Symfony\Component\Validator\Validator\ValidatorInterface $validator
     */
    private $validator;

    /**
     * Instantiate the attributes.
     *
     * @param null|GuzzleClient $client
     * @param null|Serializer $serializer
     * @param null|ValidatorInterface $validator
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __construct(
        ?GuzzleClient $client = null,
        ?Serializer $serializer = null,
        ?ValidatorInterface $validator = null
    ) {
        parent::__construct($client);
        $this->serializer = $serializer ?? (new SerializerFactory())->create();
        $this->validator = $validator ?? (new ValidatorFactory())->create();
    }


    public function create(RequestObjectInterface $request)
    {
        return $this->request(new RequestAdapter('POST', RequestMethodInterface::CREATE, $request));
    }

    public function delete(RequestObjectInterface $request)
    {
        return $this->request(new RequestAdapter('DELETE', RequestMethodInterface::DELETE, $request));
    }

    public function get(RequestObjectInterface $request)
    {
        return $this->request(new RequestAdapter('GET', RequestMethodInterface::GET, $request));
    }

    public function list(RequestObjectInterface $request)
    {
        return $this->request(new RequestAdapter('GET', RequestMethodInterface::LIST, $request));
    }

    public function update(RequestObjectInterface $request)
    {
        return $this->request(new RequestAdapter('PUT', RequestMethodInterface::UPDATE, $request));
    }

    protected function request(RequestAdapter $request): ResponseInterface
    {
        $request->validate();

        $response = parent::request($request);

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            throw new ResponseFailedException($response->getMessage());
        }

        return $request->getObject($response->getContents());
    }
}
