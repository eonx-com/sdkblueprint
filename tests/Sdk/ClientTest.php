<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Client as GuzzleClient;
use LoyaltyCorp\SdkBlueprint\Sdk\Client;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException;
use Tests\LoyaltyCorp\SdkBlueprint\HttpRequestTestCase;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\CreditCard;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Expiry;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Gateway;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\CreditCardAuthorise;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\User;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Transaction;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\Client
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects) coupling objects is necessary for test.
 */
class ClientTest extends HttpRequestTestCase
{
    /**
     * @var \LoyaltyCorp\SdkBlueprint\Sdk\Client; $client
     */
    private $client;

    /**
     * Instantiate attributes.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->client = new Client(new GuzzleClient());
    }

    /**
     * Test empty attribute violation.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException
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
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException
     */
    public function testCreditCardAuthoriseInvalidEmbeddedObjectException(): void
    {
        $creditCardAuthorise = new CreditCardAuthorise();
        $creditCardAuthorise->setGateway(new Gateway());
        $this->expectException(InvalidRequestDataException::class);
        $this->expectExceptionMessage('creditCard.expiry: This value should not be blank.');
        $creditCardAuthorise->setCreditCard(new CreditCard());

        $creditCard = new CreditCard();
        $creditCard->setExpiry(new Expiry('01'));

        $creditCardAuthorise->setCreditCard($creditCard);
        $this->expectException(InvalidRequestDataException::class);
        $this->expectExceptionMessage('creditCard.expiry.year: This value should not be blank.');

        $this->client->create($creditCardAuthorise);
    }

    /**
     * Test successful credit card authorise request.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException
     */
    public function testSuccessfulCreditCardAuthorise(): void
    {
        /** @var \GuzzleHttp\Client|\PHPUnit\Framework\MockObject\MockObject $guzzleClient */
        $guzzleClient = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $guzzleClient->method('request')
            ->willReturn($this->createMockPsrResponse('{"amount":"123","currency":"AUD"}', 200));

        $client = new Client($guzzleClient);

        $creditCardAuthorise = new CreditCardAuthorise();
        $gateway = new Gateway();
        $gateway->setService('service');
        $gateway->setCertificate('certificate');

        $creditCardAuthorise->setGateway($gateway);

        $creditCard = new CreditCard();
        $creditCard->setExpiry(new Expiry('01', '2019'));

        $creditCardAuthorise->setCreditCard($creditCard);


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
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException
     */
    public function testCreateUserSuccessful(): void
    {
        /** @var \GuzzleHttp\Client|\PHPUnit\Framework\MockObject\MockObject $guzzleClient */
        $guzzleClient = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $guzzleClient->method('request')
            ->willReturn($this->createMockPsrResponse('{"id":"uuid","name":"julian","email":"test@gmail.com"}', 200));

        $client = new Client($guzzleClient);

        $user = $client->create(new User(null, 'test', 'test@gmail.com'));
        self::assertInstanceOf(User::class, $user);
        self::assertSame('uuid', $user->getId());
    }

    /**
     * Test successful user deletion request.
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\InvalidRequestDataException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ResponseFailedException
     */
    public function testDeleteUserSuccessful(): void
    {
        /** @var \GuzzleHttp\Client|\PHPUnit\Framework\MockObject\MockObject $guzzleClient */
        $guzzleClient = $this->getMockBuilder(GuzzleClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $guzzleClient->method('request')->willReturn($this->createMockPsrResponse('{"id":"julian"}', 200));

        $client = new Client($guzzleClient);

        $user = $client->delete(new User('julian'));
        self::assertInstanceOf(User::class, $user);
        self::assertSame('julian', $user->getId());
    }
}
