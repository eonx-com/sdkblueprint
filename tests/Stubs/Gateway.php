<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs;

use LoyaltyCorp\SdkBlueprint\Sdk\BaseDataTransferObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @method null|string getCertificate()
 * @method null|string getInfo()
 * @method null|string getPassword()
 * @method null|string getService()
 * @method null|string getUsername()
 * @method self setCertificate(?string $certificate)
 * @method self setInfo(?string $info)
 * @method self setPassword(?string $password)
 * @method self setService(?string $service)
 * @method self setUsername(?string $username)
 */
class Gateway extends BaseDataTransferObject
{
    /**
     * Certificate.
     *
     * @Assert\NotBlank()
     *
     * @var null|string
     */
    protected $certificate;

    /**
     * Information.
     *
     * @var null|string
     */
    protected $info;

    /**
     * Password.
     *
     * @var null|string
     */
    protected $password;

    /**
     * Service.
     *
     * @Assert\NotBlank()
     *
     * @var null|string
     */
    protected $service;

    /**
     * Username.
     *
     * @var null|string
     */
    protected $username;
}
