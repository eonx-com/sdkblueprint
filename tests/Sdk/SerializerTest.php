<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use LoyaltyCorp\SdkBlueprint\Sdk\SerializerFactory;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\CreditCard;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Endpoints\CreditCardEndpoint;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Endpoints\BankAccount;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Endpoints\Endpoint;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Expiry;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Gateway;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Requests\CreditCardAuthorise;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Requests\Ewallet;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Requests\User;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Requests\UserCollection;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

class SerializerTest extends TestCase
{
    /**
     * @var Serializer $serializer
     */
    private $serializer;

    public function setUp()
    {
        parent::setUp();
        $this->serializer = (new SerializerFactory())->create();
    }

    public function testDenormalize(): void
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

        /** @var CreditCardAuthorise $creditCardAuthorise */
        $creditCardAuthorise = $this->serializer->denormalize($data, CreditCardAuthorise::class);

        self::assertInstanceOf(Gateway::class, $creditCardAuthorise->getGateway());
        self::assertSame('CCNA', $creditCardAuthorise->getGateway()->getCertificate());
        self::assertInstanceOf(CreditCard::class, $creditCardAuthorise->getCreditCard());
        self::assertInstanceOf(Expiry::class, $creditCardAuthorise->getCreditCard()->getExpiry());
        self::assertSame('03', $creditCardAuthorise->getCreditCard()->getExpiry()->getMonth());
        self::assertSame('2019', $creditCardAuthorise->getCreditCard()->getExpiry()->getYear());
    }

    public function testDescriminatorDenormalization(): void
    {
        /** @noinspection PhpDeprecationInspection currently this is the best way to register annotation loader*/
        AnnotationRegistry::registerUniqueLoader('class_exists');

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $discriminator = new ClassDiscriminatorFromClassMetadata($classMetadataFactory);

        $normalizer = new ObjectNormalizer(
            $classMetadataFactory,
            new CamelCaseToSnakeCaseNameConverter(),
            null,
            new ReflectionExtractor(),
            $discriminator
        );

        $serializer = new Serializer([$normalizer, new ArrayDenormalizer()], [new JsonEncoder()]);

        $data = [
            'id' => 4,
            'bsb' => '084-222',
            'pan' => '1...455',
            'type' => 'bank_account'
        ];

        $object = $serializer->denormalize($data, Endpoint::class);

        self::assertInstanceOf(BankAccount::class, $object);

        $data = [
            'id' => 4,
            'pan' => '1...455',
            'type' => 'credit_card'
        ];

        $object = $serializer->denormalize($data, Endpoint::class);

        self::assertInstanceOf(CreditCardEndpoint::class, $object);
    }

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
            foreach ($user->getEwallets() as $ewallet) {
                self::assertInstanceOf(Ewallet::class, $ewallet);
            }
        }
    }

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
