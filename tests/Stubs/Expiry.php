<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs;

use Symfony\Component\Validator\Constraints as Assert;

class Expiry
{
    /**
     * Expiry month.
     *
     * @Assert\NotBlank(groups={"create"})
     *
     * @var null|string
     */
    private $month;

    /**
     * Expiry year.
     *
     * @Assert\NotBlank(groups={"create"})
     *
     * @var null|string
     */
    private $year;

    /**
     * Instantiate attributes.
     *
     * @param null|string $month
     * @param null|string $year
     */
    public function __construct(?string $month = null, ?string $year = null)
    {
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * Get expiry month.
     *
     * @return null|string
     */
    public function getMonth(): ?string
    {
        return $this->month;
    }

    /**
     * Get expiry year.
     *
     * @return null|string
     */
    public function getYear(): ?string
    {
        return $this->year;
    }

    /**
     * Set expiry month.
     *
     * @param null|string $month
     *
     * @return void
     */
    public function setMonth(?string $month): void
    {
        $this->month = $month;
    }

    /**
     * Set expiry year.
     *
     * @param null|string $year
     *
     * @return void
     */
    public function setYear(?string $year): void
    {
        $this->year = $year;
    }
}
