<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs;

use Symfony\Component\Validator\Constraints as Assert;

class CreditCard
{
    /**
     * CVC.
     *
     * @var null|string
     */
    private $cvc;

    /**
     * Expiry object.
     *
     * @Assert\Valid(groups={"create"})
     * @Assert\NotBlank(groups={"create"})
     *
     * @var \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Expiry
     */
    private $expiry;

    /**
     * Card name.
     *
     * @var null|string
     */
    private $name;

    /**
     * Card number.
     *
     * @var null|string
     */
    private $number;

    /**
     * Get CVC.
     *
     * @return null|string
     */
    public function getCvc(): ?string
    {
        return $this->cvc;
    }

    /**
     * Get expiry object.
     *
     * @return null|\Tests\LoyaltyCorp\SdkBlueprint\Stubs\Expiry
     */
    public function getExpiry(): ?Expiry
    {
        return $this->expiry;
    }

    /**
     * Get name.
     *
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get card number.
     *
     * @return null|string
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * Set CVC.
     *
     * @param null|string $cvc
     *
     * @return void
     */
    public function setCvc(?string $cvc): void
    {
        $this->cvc = $cvc;
    }

    /**
     * Set expiry object.
     *
     * @param null|\Tests\LoyaltyCorp\SdkBlueprint\Stubs\Expiry $expiry
     *
     * @return void
     */
    public function setExpiry(?Expiry $expiry): void
    {
        $this->expiry = $expiry;
    }

    /**
     * Set name.
     *
     * @param null|string $name
     *
     * @return void
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * Set card number.
     *
     * @param null|string $number
     *
     * @return void
     */
    public function setNumber(?string $number): void
    {
        $this->number = $number;
    }
}
