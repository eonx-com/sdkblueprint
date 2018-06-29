<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Endpoints;

use LoyaltyCorp\SdkBlueprint\Sdk\BaseDataTransferObject;
use Symfony\Component\Serializer\Annotation\DiscriminatorMap;

/**
 * @DiscriminatorMap(typeProperty="type", mapping={
 *    "bank_account"="Tests\LoyaltyCorp\SdkBlueprint\Stubs\Endpoints\BankAccount",
 *    "credit_card"="Tests\LoyaltyCorp\SdkBlueprint\Stubs\Endpoints\CreditCardEndpoint"
 * })
 *
 * @SuppressWarnings(PHPMD.ShortVariable) id is a required attribute name in order to be used by serializer properly
 */
abstract class Endpoint extends BaseDataTransferObject
{
    /**
     * The id.
     *
     * @var null|string $id
     */
    protected $id;

    /**
     * Type of endpoint.
     *
     * @var null|string $type
     */
    protected $type;

    /**
     * The pan.
     *
     * @var null|string $pan
     */
    protected $pan;
}
