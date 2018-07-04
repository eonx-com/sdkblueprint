<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\RequestAdapter;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\CreditCard;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Expiry;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Gateway;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\CreditCardAuthorise;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\Ewallet;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\User;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\RequestAdapter
 */
class RequestAdapterTest extends TestCase
{
    /**
     * Make sure we filter array properly.
     *
     * @return void
     */
    public function testFilterOptions(): void
    {
        $data = [
            'name' => 'julian',
            'email' => 'test@gmail.com'
        ];

        $request = new RequestAdapter('POST', RequestMethodInterface::CREATE, new User($data));

        self::assertSame(['debug' => true,'json' => $data], $request->options());

        $data = [
            'name' => 'julian',
            'email' => null
        ];

        $request = new RequestAdapter('POST', RequestMethodInterface::CREATE, new User($data));

        self::assertSame(
            [
                'debug' => true,
                'json' => [
                    'name' => 'julian'
                ]
            ],
            $request->options()
        );
    }

    /**
     * Test get object.
     *
     * @return void
     */
    public function testGetObject(): void
    {
        $request = new RequestAdapter('GET', RequestMethodInterface::GET, new User());

        /** @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\User $user */
        $user = $request->getObject('{"id": "123", "name":"julian", "ewallets":[{"id":"1"},{"id":"2"}]}');

        self::assertInstanceOf(User::class, $user);
        self::assertSame('123', $user->getId());

        /** @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\Ewallet[] $ewallets */
        $ewallets = $user->getEwallets();

        $ewalletOne = $ewallets[0];
        self::assertSame('1', $ewalletOne->getId());

        $ewalletTwo = $ewallets[1];
        self::assertSame('2', $ewalletTwo->getId());
    }

    /**
     * Test an invalid uri.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException
     */
    public function testInvalidUri(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('There is no uri specified for unknown request method request');
        $request = new RequestAdapter(
            'POST',
            'unknown request method',
            new Ewallet(['amount' => '100'])
        );

        $request->uri();
    }

    /**
     * Test request method.
     *
     * @return void
     */
    public function testMethod(): void
    {
        $request = new RequestAdapter('GET', RequestMethodInterface::GET, new User());

        self::assertSame('GET', $request->getMethod());
    }

    /**
     * Test request options.
     *
     * @return void
     */
    public function testOptions(): void
    {
        $data = [
            'id' => 2,
            'name' => 'julian',
            'email' => 'test@gamil.com',
            'password' => null,
            'ewallets' => [
                [
                    'id' => 'ewallet3',
                    'amount' => '500'
                ],
                [
                    'id' => 'ewallet4',
                    'amount' => '500'
                ]
            ],
            'post_code' => 3333
        ];

        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::CREATE,
            new User($data)
        );

        self::assertSame(
            [
                'debug' => true,
                'json' => [
                    'name' => 'julian',
                    'email' => 'test@gamil.com',
                    'ewallets' => [
                        [
                            'id' => 'ewallet3',
                            'amount' => '500'
                        ],
                        [
                            'id' => 'ewallet4',
                            'amount' => '500'
                        ]
                    ],
                    'post_code' => 3333
                ]
            ],
            $request->options()
        );

        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::CREATE,
            new Ewallet(['amount' => 1000, 'id' => 1])
        );

        self::assertSame(
            [
                'json' => [
                    'amount' => 1000
                ]
            ],
            $request->options()
        );
    }

    /**
     * Test serialization group.
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testSerializationGroup(): void
    {
        $method = $this->getMethodAsPublic(RequestAdapter::class, 'serializationGroup');

        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::CREATE,
            new User(['name' => 'julian'])
        );

        self::assertSame(['create'], $method->invoke($request));

        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::CREATE,
            new Ewallet()
        );

        self::assertSame(['ewallet_create'], $method->invoke($request));

        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::UPDATE,
            new Ewallet()
        );

        self::assertSame(['update'], $method->invoke($request));
    }

    /**
     * Test validate method.
     *
     * @return void
     */
    public function testValidationFailed(): void
    {
        $expectedViolations = [
            'violations' => [
                'gateway.service' => [
                    'This value is too long. It should have 10 characters or less.',
                    'This value should be of type string.'
                ],
                'credit_card.expiry.month' => [
                    'This value should not be blank.'
                ],
                'credit_card.expiry.year' => [
                    'This value should not be blank.'
                ],
                'credit_card.number' => [
                    'This value should not be blank.'
                ]
            ]
        ];

        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::CREATE,
            new CreditCardAuthorise([
                'gateway' => new Gateway(['service' => 1234567891011]),
                'credit_card' => new CreditCard(['expiry' => new Expiry()])
            ])
        );

        try {
            $request->validate();
        } catch (ValidationException $exception) {
            self::assertSame('Bad request data.', $exception->getMessage());
            self::assertSame($expectedViolations, $exception->getErrors());
        }
    }

    /**
     * Test validation group.
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testValidationGroup(): void
    {
        $method = $this->getMethodAsPublic(RequestAdapter::class, 'validationGroup');

        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::CREATE,
            new User(['name' => 'julian'])
        );

        self::assertSame(['create'], $method->invoke($request));

        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::CREATE,
            new Ewallet()
        );

        self::assertSame(['ewallet_create'], $method->invoke($request));

        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::UPDATE,
            new Ewallet()
        );

        self::assertSame(['update'], $method->invoke($request));
    }

    /**
     * Test validation passed.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException
     */
    public function testValidationPassed(): void
    {
        $this->expectNotToPerformAssertions();

        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::CREATE,
            new User(['name' => 'julian', 'email' => 'test@test.com'])
        );

        $request->validate();
    }

    /**
     * Test a valid uri.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException
     */
    public function testValidUri(): void
    {
        $data = [
            'name' => 'julian',
            'email' => 'test@test.com',
            'post_code' => 3333
        ];

        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::CREATE,
            new User($data)
        );

        self::assertSame('create_uri', $request->uri());
    }
}
