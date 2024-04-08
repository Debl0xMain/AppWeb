<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USER_EMAIL', fields: ['userEmail'])]
#[UniqueEntity(fields: ['userEmail'], message: 'There is already an account with this userEmail')]
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

    #[ORM\OneToMany(targetEntity: Orders::class, mappedBy: 'users')]
    private Collection $orders;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'ref_commercial')]
    private ?self $commercial_ref = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'commercial_ref')]
    private Collection $ref_commercial;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(targetEntity: Adress::class, mappedBy: 'users')]
    private Collection $adresses;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->ref_commercial = new ArrayCollection();
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
        // $roles[] = 'ROLE_USER';
        // $roles[] = 'ROLE_COM';
        // $roles[] = 'ROLE_PRO';
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
     * @return Collection<int, Orders>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setUsers($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUsers() === $this) {
                $order->setUsers(null);
            }
        }

        return $this;
    }

    public function getCommercialRef(): ?self
    {
        return $this->commercial_ref;
    }

    public function setCommercialRef(?self $commercial_ref): static
    {
        $this->commercial_ref = $commercial_ref;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getRefCommercial(): Collection
    {
        return $this->ref_commercial;
    }

    public function addRefCommercial(self $refCommercial): static
    {
        if (!$this->ref_commercial->contains($refCommercial)) {
            $this->ref_commercial->add($refCommercial);
            $refCommercial->setCommercialRef($this);
        }

        return $this;
    }

    public function removeRefCommercial(self $refCommercial): static
    {
        if ($this->ref_commercial->removeElement($refCommercial)) {
            // set the owning side to null (unless already changed)
            if ($refCommercial->getCommercialRef() === $this) {
                $refCommercial->setCommercialRef(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

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
            $adress->setUsers($this);
        }

        return $this;
    }

    public function removeAdress(Adress $adress): static
    {
        if ($this->adresses->removeElement($adress)) {
            // set the owning side to null (unless already changed)
            if ($adress->getUsers() === $this) {
                $adress->setUsers(null);
            }
        }

        return $this;
    }


}
