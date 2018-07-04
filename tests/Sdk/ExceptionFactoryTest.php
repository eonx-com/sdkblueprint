<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use EoneoPay\Externals\HttpClient\Exceptions\InvalidApiResponseException;
use EoneoPay\Externals\HttpClient\Interfaces\ResponseInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\ExceptionFactory;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\CriticalException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\NotFoundException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\RuntimeException;
use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

/**
 * @covers \LoyaltyCorp\SdkBlueprint\Sdk\ExceptionFactory
 */
class ExceptionFactoryTest extends TestCase
{
    /**
     * Make sure the exception object has the expected type.
     *
     * @return void
     */
    public function testCreate(): void
    {
        $data = '{"message":"internal system error", "code":1999}';
        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf(CriticalException::class, $this->createExceptionMock($data));

        $data = '{"message":"internal system error", "code":1}';
        $exception = $this->createExceptionMock($data);
        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf(CriticalException::class, $exception);
        $exception = $this->createExceptionMock($data);
        self::assertSame(1, $exception->getCode());
        self::assertSame('internal system error', $exception->getMessage());

        $data = '{"message":"validation error", "code":1000}';
        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf(ValidationException::class, $this->createExceptionMock($data));

        $data = '{"message":"runtime error", "code":1100}';
        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf(RuntimeException::class, $this->createExceptionMock($data));

        $data = '{"message":"runtime error", "code":1499}';
        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf(NotFoundException::class, $this->createExceptionMock($data));
    }

    /**
     * Create exception mock by data.
     *
     * @param string $data
     *
     * @return \Exception
     */
    private function createExceptionMock(string $data): \Exception
    {
        /**
         * @var \PHPUnit\Framework\MockObject\MockObject|\EoneoPay\Externals\HttpClient\Interfaces\ResponseInterface
         */
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getContent')->willReturn($data);

        $responseException = new InvalidApiResponseException(null, $response);

        return (new ExceptionFactory($responseException))->create();
    }
}
