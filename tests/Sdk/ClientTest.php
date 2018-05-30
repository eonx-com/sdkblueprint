<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Client as GuzzleClient;
use LoyaltyCorp\SdkBlueprint\Sdk\Client;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validation;
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

    private $serializer;

    private $validator;

    public function setUp()
    {
        parent::setUp();
        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $this->validator = Validation::createValidatorBuilder()->addMethodMapping('loadValidatorMetadata')->getValidator();

        $this->client = new Client(new GuzzleClient(), $this->serializer, $this->validator);
    }

    public function testCreditCardAuthoriseEmptyAttributeException(): void
    {
        $creditCardAuthorise = new CreditCardAuthorise();
        $this->expectException(InvalidRequestDataException::class);
        $this->expectExceptionMessage('gateway: This value should not be blank.');
        $this->client->create($creditCardAuthorise);
    }

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

    public function testSuccessfulCreditCardAuthorise(): void
    {
        $guzzleClient = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $guzzleClient->method('request')->willReturn($this->createMockPsrResponse('{"amount":"123","currency":"AUD"}', 200));

        $client = new Client($guzzleClient, $this->serializer, $this->validator);

        $creditCardAuthorise = new CreditCardAuthorise();
        $creditCardAuthorise->setGateway((new Gateway())->setService('service')->setCertificate('certificate'));
        $creditCardAuthorise->setCreditCard((new CreditCard())->setExpiry(new Expiry('01', '2019')));


        $transaction = $client->create($creditCardAuthorise);
        self::assertInstanceOf(Transaction::class, $transaction);
        self::assertSame('123', $transaction->getAmount());
        self::assertSame('AUD', $transaction->getCurrency());
    }

    public function testCreateUserSuccessful(): void
    {
        $guzzleClient = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $guzzleClient->method('request')->willReturn($this->createMockPsrResponse('{"id":"uuid","name":"julian","email":"test@gmail.com"}', 200));

        $client = new Client($guzzleClient, $this->serializer, $this->validator);

        $user = $client->create((new User())->setName('test')->setEmail('test@gmail.com'));
        self::assertInstanceOf(User::class, $user);
        self::assertSame('uuid', $user->getId());
    }

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
