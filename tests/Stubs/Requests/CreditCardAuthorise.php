<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\CreditCard;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Gateway;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Transaction;

class CreditCardAuthorise implements RequestObjectInterface
{
    /**
     * The gateway object.
     *
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Valid(groups={"create"})
     *
     * @Groups({"create"})
     *
     * @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Gateway
     */
    private $gateway;

    /**
     * The credit card object.
     *
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Valid(groups={"create"})
     *
     * @Groups({"create"})
     *
     * @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\CreditCard
     */
    private $creditCard;

    /**
     * {@inheritdoc}
     */
    public function expectObject(): string
    {
        return Transaction::class;
    }

    /**
     * Get the credit card object.
     *
     * @return null|\Tests\LoyaltyCorp\SdkBlueprint\Stubs\CreditCard
     */
    public function getCreditCard(): ?CreditCard
    {
        return $this->creditCard;
    }

    /**
     * Get the gateway object.
     *
     * @return null|\Tests\LoyaltyCorp\SdkBlueprint\Stubs\Gateway
     */
    public function getGateway(): ?Gateway
    {
        return $this->gateway;
    }

    /**
     * @param mixed $creditCard
     */
    public function setCreditCard(CreditCard $creditCard): void
    {
        $this->creditCard = $creditCard;
    }

    /**
     * @param mixed $gateway
     */
    public function setGateway(Gateway $gateway): void
    {
        $this->gateway = $gateway;
    }

    /**
     * {@inheritdoc}
     */
    public function uris(): array
    {
        return [RequestMethodInterface::CREATE => 'create_uri'];
    }
}
