<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Sdk\Validation\Rules;

use Tests\LoyaltyCorp\SdkBlueprint\Stubs\DataTransferObject\Rules\UrlStub;
use Tests\LoyaltyCorp\SdkBlueprint\ValidationTestCase;

class UrlTest extends ValidationTestCase
{
    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->errorMessage = 'attribute must be a valid url';
        $this->invalidValue = 'invalid url';
        $this->objectStubClass = UrlStub::class;
        $this->validValue = 'http://localhost';
    }
}
