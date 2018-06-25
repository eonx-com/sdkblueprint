<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs;

use LoyaltyCorp\SdkBlueprint\Sdk\BaseDataTransferObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @method null|string getCvc()
 * @method null|Expiry getExpiry()
 * @method null|string getName()
 * @method null|string getNumber()
 * @method self setCvc(?string $cvc)
 * @method self setExpiry(?Expiry $cvc)
 * @method self setName(?string $name)
 * @method self setNumber(?string $number)
 */
class CreditCard extends BaseDataTransferObject
{
    /**
     * CVC.
     *
     * @var null|string
     */
    protected $cvc;

    /**
     * Expiry object.
     *
     * @Assert\Valid(groups={"create"})
     * @Assert\NotBlank(groups={"create"})
     *
     * @var null|\Tests\LoyaltyCorp\SdkBlueprint\Stubs\Expiry
     */
    protected $expiry;

    /**
     * Card name.
     *
     * @var null|string
     */
    protected $name;

    /**
     * Card number.
     *
     * @Assert\NotBlank(groups={"create"})
     *
     * @var null|string
     */
    protected $number;
}
