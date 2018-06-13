<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
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
     * Set credit card object.
     *
     * @param \Tests\LoyaltyCorp\SdkBlueprint\Stubs\CreditCard $creditCard
     *
     * @return void
     */
    public function setCreditCard(CreditCard $creditCard): void
    {
        $this->creditCard = $creditCard;
    }

    /**
     * Set gateway object.
     *
     * @param \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Gateway $gateway
     *
     * @return void
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
