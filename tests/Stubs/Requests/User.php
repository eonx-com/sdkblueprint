<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\SdkBlueprint\Stubs\Requests;

use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestMethodInterface;
use LoyaltyCorp\SdkBlueprint\Sdk\Interfaces\RequestObjectInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

class User implements RequestObjectInterface
{
    /**
     * User id
     *
     * @Assert\NotBlank(groups={"delete"})
     *
     * @Groups({"delete"})
     *
     * @var null|string
     */
    private $id;

    /**
     * Name.
     *
     * @Assert\NotBlank(groups={"update","create"})
     *
     * @Groups({"create", "update"})
     *
     * @var null|string
     */
    private $name;

    /**
     * Email.
     *
     * @Assert\NotBlank(groups={"update","create"})
     *
     * @Groups({"create", "update"})
     *
     * @var null|string
     */
    private $email;

    /**
     * Ewallets.
     *
     * @var Ewallet[]
     */
    private $ewallets;

    /**
     * @Groups({"create", "update"})
     */
    private $postCode;

    /**
     * Instantiate attributes.
     *
     * @param null|string $id
     * @param null|string $name
     * @param null|string $email
     * @param null|int $postCode
     */
    public function __construct(
        ?string $id = null,
        ?string $name = null,
        ?string $email = null,
        ?int $postCode = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->postCode = $postCode;
    }

    /**
     * Add ewallet object into the collection.
     *
     * @param Ewallet $ewallet
     *
     * @return void
     */
    public function addEwallet(Ewallet $ewallet): void
    {
        $this->ewallets[] = $ewallet;
    }

    /**
     * {@inheritdoc}
     */
    public function expectObject(): string
    {
        return self::class;
    }

    /**
     * Get email.
     *
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Get ewallet collection.
     *
     * @return Ewallet[]
     */
    public function getEwallets(): array
    {
        return $this->ewallets;
    }

    /**
     * Get user id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
     * Get post code.
     *
     * @return null|int
     */
    public function getPostCode(): ?int
    {
        return $this->postCode;
    }

    /**
     * Set email.
     *
     * @param null|string $email
     *
     * @return void
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * Set ewallet collection.
     *
     * @param Ewallet[] $ewallets
     *
     * @return void
     */
    public function setEwallets(array $ewallets): void
    {
        $this->ewallets = $ewallets;
    }

    /**
     * Set user id.
     *
     * @param $id
     *
     * @return void
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * Set name.
     *
     * @param null|string $name
     *
     * @return void
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * Set post code.
     *
     * @param null|int $postCode
     *
     * @return void
     */
    public function setPostCode(?int $postCode): void
    {
        $this->postCode = $postCode;
    }

    /**
     * {@inheritdoc}
     */
    public function uris(): array
    {
        return [
            RequestMethodInterface::CREATE => 'create_uri',
            RequestMethodInterface::DELETE => 'delete'
        ];
    }
}
