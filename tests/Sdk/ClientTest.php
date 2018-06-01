<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Client as GuzzleClient;
use LoyaltyCorp\SdkBlueprint\Sdk\Client;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
use LoyaltyCorp\SdkBlueprint\Sdk\SerializerFactory;
use LoyaltyCorp\SdkBlueprint\Sdk\ValidatorFactory;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\CreditCard;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Expiry;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Gateway;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Requests\CreditCardAuthorise;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Transaction;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Requests\User;
use Tests\LoyaltyCorp\SdkBlueprint\HttpRequestTestCase;

class ClientTest extends HttpRequestTestCase
{
    /**
     * @var Client $client
     */
    private $client;

    /**
     * @var \Symfony\Component\Serializer\Serializer $serializer
     */
    private $serializer;

    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     */
    private $validator;

    /**
     * Instantiate attributes.
     *
     * @return void
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->serializer = (new SerializerFactory())->create();
        $this->validator = (new ValidatorFactory())->create();

        $this->client = new Client(new GuzzleClient(), $this->serializer, $this->validator);
    }

    /**
     * Test empty attribute violation.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestUriException
     */
    public function testCreditCardAuthoriseEmptyAttributeException(): void
    {
        $creditCardAuthorise = new CreditCardAuthorise();
        $this->expectException(InvalidRequestDataException::class);
        $this->expectExceptionMessage('gateway: This value should not be blank.');
        $this->client->create($creditCardAuthorise);
    }

    /**
     * Test empty object instance violation.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestUriException
     */
    public function testCreditCardAuthoriseInvalidEmbeddedObjectException(): void
    {
        $creditCardAuthorise = new CreditCardAuthorise();
        $creditCardAuthorise->setGateway(new Gateway());
        $this->expectException(InvalidRequestDataException::class);
        $this->expectExceptionMessage('creditCard.expiry: This value should not be blank.');
        $creditCardAuthorise->setCreditCard(new CreditCard());


        $creditCardAuthorise->setCreditCard((new CreditCard())->setExpiry(new Expiry()));
        $this->expectException(InvalidRequestDataException::class);
        $this->expectExceptionMessage('creditCard.expiry.month: This value should not be blank.creditCard.expiry.year: This value should not be blank.');

        $this->client->create($creditCardAuthorise);
    }

    /**
     * Test successful credit card authorise request.
     *
     * @return void
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestUriException
     */
    public function testSuccessfulCreditCardAuthorise(): void
    {
        $guzzleClient = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $guzzleClient
            ->method('request')
            ->willReturn($this->createMockPsrResponse('{"amount":"123","currency":"AUD"}', 200));

        $client = new Client($guzzleClient, $this->serializer, $this->validator);

        $creditCardAuthorise = new CreditCardAuthorise();
        $creditCardAuthorise->setGateway((new Gateway())->setService('service')->setCertificate('certificate'));
        $creditCardAuthorise->setCreditCard((new CreditCard())->setExpiry(new Expiry('01', '2019')));


        $transaction = $client->create($creditCardAuthorise);
        self::assertInstanceOf(Transaction::class, $transaction);
        self::assertSame('123', $transaction->getAmount());
        self::assertSame('AUD', $transaction->getCurrency());
    }

    /**
     * Test successful user creation request.
     *
     * @return void
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestUriException
     */
    public function testCreateUserSuccessful(): void
    {
        $guzzleClient = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $guzzleClient
            ->method('request')
            ->willReturn($this->createMockPsrResponse('{"id":"uuid","name":"julian","email":"test@gmail.com"}', 200));

        $client = new Client($guzzleClient, $this->serializer, $this->validator);

        $user = $client->create((new User())->setName('test')->setEmail('test@gmail.com'));
        self::assertInstanceOf(User::class, $user);
        self::assertSame('uuid', $user->getId());
    }

    /**
     * Test successful user deletion request.
     *
     * @return void
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestUriException
     */
    public function testDeleteUserSuccessful(): void
    {
        $guzzleClient = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $guzzleClient->method('request')->willReturn($this->createMockPsrResponse('{"id":"julian"}', 200));

        $client = new Client($guzzleClient, $this->serializer, $this->validator);


        $user = $client->delete((new User())->setId('julian'));
        self::assertInstanceOf(User::class, $user);
        self::assertSame('julian', $user->getId());
    }
}
