<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\CreditCard;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Expiry;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Gateway;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Requests\CreditCardAuthorise;
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
        $this->serializer = new Serializer([new ObjectNormalizer(null, null, null, new ReflectionExtractor())], [new JsonEncoder()]);
    }

    public function testDenormalize():void
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
}
