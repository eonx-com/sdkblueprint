<?php
declare(strict_types=1);

namespace LoyaltyCorp\SdkBlueprint\Sdk;

use Tests\LoyaltyCorp\SdkBlueprint\TestCase;

class ClientTest extends TestCase
{
    private $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = new Client(null, null);
    }

    public function testRequest()
    {

    }
}
