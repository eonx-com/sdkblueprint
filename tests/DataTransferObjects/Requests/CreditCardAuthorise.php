<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Requests;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Transaction;

class CreditCardAuthorise implements RequestInterface
{
    private $gateway;
    private $creditCard;

    /**
     * @return mixed
     */
    public function getGateway()
    {
        return $this->gateway;
    }

    /**
     * @param mixed $gateway
     */
    public function setGateway($gateway): void
    {
        $this->gateway = $gateway;
    }

    /**
     * @return mixed
     */
    public function getCreditCard()
    {
        return $this->creditCard;
    }

    /**
     * @param mixed $creditCard
     */
    public function setCreditCard($creditCard): void
    {
        $this->creditCard = $creditCard;
    }

    public function expectObject(): ?string
    {
        return Transaction::class;
    }

    public function getUri(): string
    {
        return 'localhost';
    }

    public function getOptions(): array
    {
        return ['json' => $this->toArray()];
    }

    public function toArray()
    {
        return ['id' => 123];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('gateway', new Assert\Valid());
        $metadata->addPropertyConstraint('gateway', new Assert\NotBlank());
        $metadata->addPropertyConstraint('creditCard', new Assert\Valid());
    }

}
