<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use GuzzleHttp\Client as GuzzleClient;
use LoyaltyCorp\SdkBlueprint\Sdk\Client;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\CriticalException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException;
use Tests\LoyaltyCorp\SdkBlueprint\HttpRequestTestCase;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\CreditCard;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Expiry;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Gateway;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\CreditCardAuthorise;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\User;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\UserCollection;
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
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function testCreditCardAuthoriseEmptyAttributeException(): void
    {
        $creditCardAuthorise = new CreditCardAuthorise();
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('gateway: This value should not be blank.');
        $this->client->create($creditCardAuthorise);
    }

    /**
     * Test empty object instance violation.
     *
     * @return void
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function testCreditCardAuthoriseInvalidEmbeddedObjectException(): void
    {
        $creditCardAuthorise = new CreditCardAuthorise();
        $creditCardAuthorise->setGateway(new Gateway());
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('creditCard.expiry: This value should not be blank.');
        $creditCardAuthorise->setCreditCard(new CreditCard());

        $creditCard = new CreditCard();
        $creditCard->setExpiry(new Expiry('01'));

        $creditCardAuthorise->setCreditCard($creditCard);
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('creditCard.expiry.year: This value should not be blank.');

        $this->client->create($creditCardAuthorise);
    }

    /**
     * Test when request failed.
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testFailedResponse(): void
    {
        $this->expectException(CriticalException::class);
        $this->expectExceptionMessage('system error');

        $client = $this->createSdkClientWithFailedResponse();
        $client->get(new User('123'));
    }

    /**
     * Test successful credit card authorise request.
     *
     * @return void
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function testSuccessfulCreditCardAuthorise(): void
    {
        $client = $this->createSdkClientWithPsrResponse('{"amount":"123","currency":"AUD"}', 200);

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
     * @throws \Exception
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCreateUserSuccessfully(): void
    {
        $client = $this->createSdkClientWithPsrResponse('{"id":"uuid","name":"julian","email":"test@gmail.com"}', 200);
        $user = $client->create(new User(null, 'test', 'test@gmail.com'));

        self::assertInstanceOf(User::class, $user);
        self::assertSame('uuid', $user->getId());
    }

    /**
     * Test successful user deletion request.
     *
     * @throws \Exception
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDeleteUserSuccessfully(): void
    {
        $client = $this->createSdkClientWithPsrResponse('{"id":"julian"}', 200);
        $user = $client->delete(new User('julian'));

        self::assertInstanceOf(User::class, $user);
        self::assertSame('julian', $user->getId());
    }

    /**
     * Test a successful get user request.
     *
     * @throws \Exception
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetUserSuccessfully(): void
    {
        $client = $this->createSdkClientWithPsrResponse('{"id":"1234", "email":"test@gmail.com"}', 200);

        $user = $client->get(new User('1234'));

        self::assertInstanceOf(User::class, $user);
        self::assertSame('test@gmail.com', $user->getEmail());
    }

    /**
     * Test a successful list user request.
     *
     * @throws \Exception
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testListUserSuccessfully(): void
    {
        $client = $this->createSdkClientWithPsrResponse(
            '[{"id":1, "email":"test1@gmail.com"},{"id":2, "email":"test2@gmail.com"}]',
            200
        );

        $users = $client->list(new UserCollection());

        /** @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\User $userOne */
        $userOne = $users[0];
        self::assertSame('1', $userOne->getId());
        self::assertSame('test1@gmail.com', $userOne->getEmail());

        /** @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\User $userTwo */
        $userTwo = $users[1];
        self::assertSame('2', $userTwo->getId());
        self::assertSame('test2@gmail.com', $userTwo->getEmail());
    }

    /**
     * Test a successful update user request.
     *
     * @throws \Exception
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testUpdateUserSuccessfully(): void
    {
        $client = $this->createSdkClientWithPsrResponse('{"id":"1234", "name":"julian test"}', 200);

        $user = $client->update(new User('1234', 'julian test', 'test@gmail.com'));

        self::assertInstanceOf(User::class, $user);
        self::assertSame('julian test', $user->getName());
    }
}
