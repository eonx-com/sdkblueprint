<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests;

use LoyaltyCorp\SdkBlueprint\Sdk\BaseDataTransferObject;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\CreditCard;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Gateway;
use Tests\LoyaltyCorp\SdkBlueprint\Stubs\Transaction;

/**
 * @method null|CreditCard getCreditCard()
 * @method null|Gateway getGateway()
 * @method self setGateway(?Gateway $gateway)
 * @method self setCreditCard(?CreditCard $creditCard)
 */
class CreditCardAuthorise extends BaseDataTransferObject implements RequestObjectInterface
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
    public $gateway;

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
    public $creditCard;

    /**
     * {@inheritdoc}
     */
    public function expectObject(): string
    {
        return Transaction::class;
    }

    /**
     * {@inheritdoc}
     */
    public function uris(): array
    {
        return [RequestMethodInterface::CREATE => 'create_uri'];
    }
}
