<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Expiry
{
    private $month;
    private $year;

    public function __construct(string $month, string $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function getMonth(): string
    {
        return $this->month;
    }

    /**
     * @return string
     */
    public function getYear(): string
    {
        return $this->year;
    }

    /**
     * @param mixed $month
     */
    public function setMonth($month): void
    {
        $this->month = $month;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year): void
    {
        $this->year = $year;
    }


    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('month', new Assert\NotBlank());
        $metadata->addPropertyConstraint('year', new Assert\NotBlank());
    }
}
