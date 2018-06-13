<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs;

use Symfony\Component\Validator\Constraints as Assert;

class Gateway
{
    /**
     * Certificate.
     *
     * @Assert\NotBlank()
     *
     * @var null|string
     */
    private $certificate;

    /**
     * Information.
     *
     * @var null|string
     */
    private $info;

    /**
     * Password.
     *
     * @var null|string
     */
    private $password;

    /**
     * Service.
     *
     * @Assert\NotBlank()
     *
     * @var null|string
     */
    private $service;

    /**
     * Username.
     *
     * @var null|string
     */
    private $username;

    /**
     * Get certificate.
     *
     * @return null|string
     */
    public function getCertificate(): ?string
    {
        return $this->certificate;
    }

    /**
     * Set the certificate.
     *
     * @param null|string $certificate
     *
     * @return void
     */
    public function setCertificate(?string $certificate): void
    {
        $this->certificate = $certificate;
    }

    /**
     * Get information.
     *
     * @return null|string
     */
    public function getInfo(): ?string
    {
        return $this->info;
    }

    /**
     * Set information.
     *
     * @param null|string $info
     *
     * @return void
     */
    public function setInfo(?string $info): void
    {
        $this->info = $info;
    }

    /**
     * Get password.
     *
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set password.
     *
     * @param null|string $password
     *
     * @return void
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * Get service.
     *
     * @return null|string
     */
    public function getService(): ?string
    {
        return $this->service;
    }

    /**
     * Set service.
     *
     * @param null|string $service
     *
     * @return void
     */
    public function setService(?string $service): void
    {
        $this->service = $service;
    }

    /**
     * Get username.
     *
     * @return null|string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set username.
     *
     * @param null|string $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }
}
