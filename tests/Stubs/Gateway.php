<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Gateway
{
    /**
     * @var null|string
     */
    private $certificate;

    /**
     * @var null|string
     */
    private $info;

    /**
     * @var null|string
     */
    private $password;

    /**
     * @var null|string
     */
    private $service;

    /**
     * @var null|string
     */
    private $username;

    /**
     * @return mixed
     */
    public function getCertificate()
    {
        return $this->certificate;
    }

    /**
     * Set the certificate.
     *
     * @param $certificate
     *
     * @return \Tests\LoyaltyCorp\SdkBlueprint\Stubs\Gateway
     */
    public function setCertificate($certificate): self
    {
        $this->certificate = $certificate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param mixed $info
     */
    public function setInfo($info): void
    {
        $this->info = $info;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }


    public function setService($service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('service', new Assert\NotBlank());
        $metadata->addPropertyConstraint('certificate', new Assert\NotBlank());
    }
}
