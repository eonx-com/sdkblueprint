<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Endpoints;

use Symfony\Component\Serializer\Annotation\DiscriminatorMap;

/**
 * @DiscriminatorMap(typeProperty="type", mapping={
 *    "bank_account"="Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Endpoints\BankAccount",
 *    "credit_card"="Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Endpoints\CreditCardEndpoint"
 * })
 */
abstract class Endpoint
{
    /**
     * @var null|string $id
     */
    private $id;

    /**
     * @var null|string $type
     */
    private $type;

    /**
     * @var null|string $pan
     */
    private $pan;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPan()
    {
        return $this->pan;
    }

    /**
     * @param mixed $pan
     */
    public function setPan($pan): void
    {
        $this->pan = $pan;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }
}
