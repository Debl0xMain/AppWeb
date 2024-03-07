<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USER_EMAIL', fields: ['userEmail'])]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $userEmail = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    private ?string $userName = null;

    #[ORM\Column(length: 100)]
    private ?string $userFristName = null;

    #[ORM\Column(length: 100)]
    private ?string $userRef = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $UserPhone = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2)]
    private ?string $userCoefficient = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userCompanyName = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $userCompanySiret = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    private ?string $userCompanyCoefficient = null;

    #[ORM\ManyToMany(targetEntity: Adress::class, mappedBy: 'users')]
    private Collection $adresses;

    public function __construct()
    {
        $this->adresses = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }

    public function setUserEmail(string $userEmail): static
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->userEmail;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): static
    {
        $this->userName = $userName;

        return $this;
    }

    public function getUserFristName(): ?string
    {
        return $this->userFristName;
    }

    public function setUserFristName(string $userFristName): static
    {
        $this->userFristName = $userFristName;

        return $this;
    }

    public function getUserRef(): ?string
    {
        return $this->userRef;
    }

    public function setUserRef(string $userRef): static
    {
        $this->userRef = $userRef;

        return $this;
    }

    public function getUserPhone(): ?string
    {
        return $this->UserPhone;
    }

    public function setUserPhone(?string $UserPhone): static
    {
        $this->UserPhone = $UserPhone;

        return $this;
    }

    public function getUserCoefficient(): ?string
    {
        return $this->userCoefficient;
    }

    public function setUserCoefficient(string $userCoefficient): static
    {
        $this->userCoefficient = $userCoefficient;

        return $this;
    }

    public function getUserCompanyName(): ?string
    {
        return $this->userCompanyName;
    }

    public function setUserCompanyName(?string $userCompanyName): static
    {
        $this->userCompanyName = $userCompanyName;

        return $this;
    }

    public function getUserCompanySiret(): ?string
    {
        return $this->userCompanySiret;
    }

    public function setUserCompanySiret(?string $userCompanySiret): static
    {
        $this->userCompanySiret = $userCompanySiret;

        return $this;
    }

    public function getUserCompanyCoefficient(): ?string
    {
        return $this->userCompanyCoefficient;
    }

    public function setUserCompanyCoefficient(?string $userCompanyCoefficient): static
    {
        $this->userCompanyCoefficient = $userCompanyCoefficient;

        return $this;
    }

    /**
     * @return Collection<int, Adress>
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function addAdress(Adress $adress): static
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses->add($adress);
            $adress->addUser($this);
        }

        return $this;
    }

    public function removeAdress(Adress $adress): static
    {
        if ($this->adresses->removeElement($adress)) {
            $adress->removeUser($this);
        }

        return $this;
    }

}
