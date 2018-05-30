<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class CreditCard
{
    private $expiry;
    private $cvc;
    private $name;
    private $number;

    /**
     * @return mixed
     */
    public function getExpiry(): Expiry
    {
        return $this->expiry;
    }

    public function setExpiry(Expiry $expiry): self
    {
        $this->expiry = $expiry;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCvc()
    {
        return $this->cvc;
    }

    /**
     * @param mixed $cvc
     */
    public function setCvc($cvc): void
    {
        $this->cvc = $cvc;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number): void
    {
        $this->number = $number;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('expiry', new Assert\Valid());
        $metadata->addPropertyConstraint('expiry', new Assert\NotBlank());
    }
}
