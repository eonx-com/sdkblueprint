<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\SerializerFactory;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\CreditCard;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Endpoints\BankAccount;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Endpoints\CreditCardEndpoint;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Endpoints\Endpoint;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Expiry;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Gateway;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\CreditCardAuthorise;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\Ewallet;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\User;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\SerializerFactory
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects) coupling objects is necessary for test.
 */
class SerializerFactoryTest extends TestCase
{
    /**
     * @var \Symfony\Component\Serializer\Serializer $serializer
     */
    private $serializer;

    /**
     * Instantiate attribute.
     *
     * @return void
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->serializer = (new SerializerFactory())->create();
    }

    /**
     * Test object denormalization.
     *
     * @return void
     */
    public function testDenormalization(): void
    {
        $data = [
            'gateway' => [
                'certificate' => 'CCNA',
                'service' => 'my service'
            ],
            'credit_card' => [
                'expiry' => [
                    'month' => '03',
                    'year' => '2019'
                ],
                'cvc' => '123',
                'number' => '4200000000000000'
            ]
        ];

        /** @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\CreditCardAuthorise $creditCardAuthorise */
        $creditCardAuthorise = $this->serializer->denormalize($data, CreditCardAuthorise::class);

        /** @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Gateway $gateway */
        $gateway = $creditCardAuthorise->getGateway();

        /** @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\CreditCard $creditCard */
        $creditCard = $creditCardAuthorise->getCreditCard();

        /** @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Expiry; $expiry */
        $expiry = $creditCard->getExpiry();

        self::assertInstanceOf(Gateway::class, $gateway);
        self::assertSame('CCNA', $gateway->getCertificate());
        self::assertInstanceOf(CreditCard::class, $creditCard);
        self::assertInstanceOf(Expiry::class, $expiry);
        self::assertSame('03', $expiry->getMonth());
        self::assertSame('2019', $expiry->getYear());
    }

    /**
     * Test denormalization for descriminator.
     *
     * @return void
     */
    public function testDescriminatorDenormalization(): void
    {
        $data = [
            'id' => '4',
            'bsb' => '084-222',
            'pan' => '1...455',
            'type' => 'bank_account'
        ];

        $object = $this->serializer->denormalize($data, Endpoint::class);

        self::assertInstanceOf(BankAccount::class, $object);

        $data = [
            'id' => '4',
            'pan' => '1...455',
            'type' => 'credit_card'
        ];

        $object = $this->serializer->denormalize($data, Endpoint::class);

        self::assertInstanceOf(CreditCardEndpoint::class, $object);
    }

    /**
     * Test nested denormalization.
     *
     * @return void
     */
    public function testNestedDenormalization(): void
    {
        $data = [
            [
                'id' => 1,
                'email' => 'test1@gamil.com',
                'ewallets' => [
                    [
                        'id' => 'ewallet1',
                        'amount' => '100'
                    ],
                    [
                        'id' => 'ewallet2',
                        'amount' => '200'
                    ]
                ]
            ],
            [
                'id' => 2,
                'email' => 'test2@gamil.com',
                'ewallets' => [
                    [
                        'id' => 'ewallet3',
                        'amount' => '500'
                    ],
                    [
                        'id' => 'ewallet4',
                        'amount' => '500'
                    ]
                ]
            ],
        ];

        $users = $this->serializer->denormalize($data, \sprintf('%s[]', User::class));

        foreach ($users as $user) {
            self::assertInstanceOf(User::class, $user);

            /** @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\User $user */
            foreach ($user->getEwallets() as $ewallet) {
                self::assertInstanceOf(Ewallet::class, $ewallet);
            }
        }
    }

    /**
     * Test normalization.
     *
     * @return void
     */
    public function testNormalization(): void
    {
        $user = new User('123', 'julian', 'test@test.com');

        $expect = [
            'name' => 'julian',
            'email' => 'test@test.com',
            'post_code' => null
        ];

        self::assertSame($expect, $this->serializer->normalize($user, null, ['groups' => ['create']]));

        $expect = [
            'id' => '123'
        ];

        self::assertSame($expect, $this->serializer->normalize($user, null, ['groups' => ['delete']]));
    }
}
