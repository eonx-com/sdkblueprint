<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs;

use LoyaltyCorp\SdkBlueprint\Sdk\BaseDataTransferObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @method null|string getMonth()
 * @method null|string getYear()
 * @method self setMonth(?string $month)
 * @method self setYear(?string $year)
 */
class Expiry extends BaseDataTransferObject
{
    /**
     * Expiry month.
     *
     * @Assert\NotBlank(groups={"create"})
     *
     * @var null|string
     */
    public $month;

    /**
     * Expiry year.
     *
     * @Assert\NotBlank(groups={"create"})
     *
     * @var null|string
     */
    public $year;
}
