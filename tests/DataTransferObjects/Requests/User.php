<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\DataTransferObjects\Requests;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

class User implements RequestObjectInterface
{
    /**
     * @Assert\NotBlank(groups={"delete"})
     * @Groups({"delete"})
     */
    private $id;

    /**
     * @Assert\NotBlank(groups={"update","create"})
     * @Groups({"create", "update"})
     */
    private $name;

    /**
     * @Assert\NotBlank(groups={"update","create"})
     * @Groups({"create", "update"})
     */
    private $email;

    /**
     * @var Ewallet[]
     */
    private $ewallets;

    /**
     * @Groups({"create", "update"})
     */
    private $postCode;

    public function __construct(?string $id = null, ?string $name = null, ?string $email = null, ?int $postCode = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->postCode = $postCode;
    }

    public function addEwallet(Ewallet $ewallet): void
    {
        $this->ewallets[] = $ewallet;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }


    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * @param mixed $postCode
     */
    public function setPostCode($postCode): void
    {
        $this->postCode = $postCode;
    }

    /**
     * @return Ewallet[]
     */
    public function getEwallets(): array
    {
        return $this->ewallets;
    }

    /**
     * @param Ewallet[] $ewallets
     */
    public function setEwallets(array $ewallets): void
    {
        $this->ewallets = $ewallets;
    }

    public function expectObject(): string
    {
        return self::class;
    }

    public function options(): array
    {
        return [
            RequestMethodInterface::CREATE => 'create_uri',
            RequestMethodInterface::UPDATE => 'update_uri',
            RequestMethodInterface::DELETE => 'delete_uri'
        ];
    }

    public function uris(): array
    {
        return [
            RequestMethodInterface::CREATE => 'create_uri',
            RequestMethodInterface::DELETE => 'delete'
        ];
    }
}
