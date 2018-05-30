<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects;

use Symfony\Component\Validator\Constraints as Assert;

class Expiry
{
    /**
     * @Assert\NotBlank(groups={"create"})
     */
    private $month;

    /**
     * @Assert\NotBlank(groups={"create"})
     */
    private $year;

    public function __construct(?string $month = null, ?string $year = null)
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
}
