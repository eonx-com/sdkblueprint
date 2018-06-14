<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk;

use LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\RequestAdapter;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\Ewallet;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\User;
use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

class RequestAdapterTest extends TestCase
{
    /**
     * Test get returned object.
     *
     * @return void
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testGetObject(): void
    {
        $request = new RequestAdapter('GET', RequestMethodInterface::GET, new User());

        /** @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests\User $user */
        $user = $request->getObject('{"id": "123"}');

        self::assertInstanceOf(User::class, $user);
        self::assertSame('123', $user->getId());
    }

    /**
     * Test request method.
     *
     * @return void
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testMethod(): void
    {
        $request = new RequestAdapter('GET', RequestMethodInterface::GET, new User());

        self::assertSame('GET', $request->method());
    }

    /**
     * Test request options.
     *
     * @return void
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testOptions(): void
    {
        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::CREATE,
            new User(null, 'julian', 'test@test.com', 3333)
        );

        self::assertSame(
            [
                'debug' => true,
                'json' => [
                    'name' => 'julian',
                    'email' => 'test@test.com',
                    'post_code' => 3333
                ]
            ],
            $request->options()
        );

        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::CREATE,
            new Ewallet('1000', '1')
        );

        self::assertSame(
            [
                'json' => [
                    'amount' => '1000'
                ]
            ],
            $request->options()
        );
    }

    /**
     * Test a valid uri.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testValidUri(): void
    {
        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::CREATE,
            new User(null, 'julian', 'test@test.com', 3333)
        );

        self::assertSame('create_uri', $request->uri());
    }

    /**
     * Test an invalid uri.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testInvalidUri(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('no uri exists for unknown request method method');
        $request = new RequestAdapter(
            'POST',
            'unknown request method',
            new Ewallet('123')
        );

        $request->uri();
    }

    /**
     * Test validate method.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testValidationFailed(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('email: This value should not be blank.');
        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::CREATE,
            new User(null, 'julian')
        );

        $request->validate();
    }

    /**
     * Test validation passed.
     *
     * @return void
     *
     * @throws \LoyaltyCorp\SdkBlueprint\Sdk\Exceptions\ValidationException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testValidationPassed(): void
    {
        $this->expectNotToPerformAssertions();

        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::CREATE,
            new User(null, 'julian', 'test@test.com')
        );

        $request->validate();
    }

    /**
     * Test validation group.
     *
     * @return void
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
     */
    public function testValidationGroup(): void
    {
        $method = $this->getMethodAsPublic(RequestAdapter::class, 'validationGroup');

        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::CREATE,
            new User(null, 'julian')
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
     * Test serialization group.
     *
     * @return void
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
     */
    public function testSerializationGroup(): void
    {
        $method = $this->getMethodAsPublic(RequestAdapter::class, 'serializationGroup');

        $request = new RequestAdapter(
            'POST',
            RequestMethodInterface::CREATE,
            new User(null, 'julian')
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
}
