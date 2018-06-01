<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Requests;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\CreditCard;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Gateway;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Transaction;

class CreditCardAuthorise implements RequestObjectInterface
{
    /**
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Valid(groups={"create"})
     * @Groups({"create"})
     */
    private $gateway;

    /**
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Valid(groups={"create"})
     * @Groups({"create"})
     */
    private $creditCard;

    /**
     * @return mixed
     */
    public function getGateway(): ?Gateway
    {
        return $this->gateway;
    }

    /**
     * @param mixed $gateway
     */
    public function setGateway(Gateway $gateway): void
    {
        $this->gateway = $gateway;
    }

    /**
     * @return mixed
     */
    public function getCreditCard(): ?CreditCard
    {
        return $this->creditCard;
    }

    /**
     * @param mixed $creditCard
     */
    public function setCreditCard(CreditCard $creditCard): void
    {
        $this->creditCard = $creditCard;
    }

    public function expectObject(): ?string
    {
        return Transaction::class;
    }

    public function getUris(): array
    {
        return [RequestMethodInterface::CREATE => 'create_uri'];
    }

    public function getOptions(): array
    {
        return [];
    }
}
