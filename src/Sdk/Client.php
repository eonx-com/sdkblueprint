<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestData;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ClientInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Validation\Validator;

class Client implements ClientInterface
{
    /**
     * Guzzle HTTP client for requests
     *
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Validator instance.
     *
     * @var null|\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Validator
     */
    private $validator;

    /**
     * Instantiate the object and fill all its attributes by given data.
     *
     * @param null|\GuzzleHttp\Client $client
     * @param null|\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Validator $validator
     */
    public function __construct(?GuzzleClient $client = null, ?Validator $validator)
    {
        $this->client = $client ?? new GuzzleClient();
        $this->validator = $validator ?? new Validator();
    }

    /**
     * @param \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestInterface $request
     *
     * @return \LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\ResponseInterface
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\UndefinedValidationRuleException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestData
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(RequestInterface $request): ResponseInterface
    {
        try {
            if ($request instanceof DataTransferObject) {
                $errors = $this->validator->validate($request);

                if (\count($errors) > 0) {
                    throw new InvalidRequestData(\json_encode($errors));
                }
            }

            /** @noinspection PhpUnhandledExceptionInspection all exception will be caught*/
            $response = $this->client->request($request->getMethod(), $request->getUri(), $request->getOptions());
        } catch (RequestException $exception) {
            return (new ResponseFactory())->createErrorResponse($exception);
        }

        return (new ResponseFactory())->createSuccessfulResponse($response);
    }
}
