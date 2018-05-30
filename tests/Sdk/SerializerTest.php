<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\SerializerFactory;
use Symfony\Component\Serializer\Serializer;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\CreditCard;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Expiry;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Gateway;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Requests\CreditCardAuthorise;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Requests\User;
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
            'creditCard' => [
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

    public function testNormalization(): void
    {
        $user = new User('123', 'julian', 'test@test.com');

        $expect = [
            'name' => 'julian',
            'email' => 'test@test.com'
        ];

        self::assertSame($expect, $this->serializer->normalize($user, null, ['groups' => ['create']]));

        $expect = [
            'id' => '123'
        ];

        self::assertSame($expect, $this->serializer->normalize($user, null, ['groups' => ['delete']]));
    }
}
