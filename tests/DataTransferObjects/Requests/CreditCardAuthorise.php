<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Requests;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\RequestObject;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Transaction;

class CreditCardAuthorise extends RequestObject
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

    public function getUris(): array
    {
        return [RequestMethodInterface::CREATE => 'create_uri'];
    }

    public function getOptions(): array
    {
        return [
            RequestMethodInterface::CREATE => ['json'=> ['data']]
        ];
    }

    public function getValidationGroups(): array
    {
        return [];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('gateway', new Assert\Valid());
        $metadata->addPropertyConstraint('gateway', new Assert\NotBlank());
        $metadata->addPropertyConstraint('creditCard', new Assert\Valid());
    }
}
