<?php

namespace App\Entity;

use App\Repository\AdressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdressRepository::class)]
class Adress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $adrNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $adrStreet = null;

    #[ORM\Column(length: 255)]
    private ?string $adrZipCode = null;

    #[ORM\Column(length: 255)]
    private ?string $adrCity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adrAddInfo = null;

    #[ORM\ManyToMany(targetEntity: Users::class, inversedBy: 'yes')]
    private Collection $users;

    #[ORM\ManyToOne(inversedBy: 'User')]
    private ?Adress $Adress = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdrNumber(): ?string
    {
        return $this->adrNumber;
    }

    public function setAdrNumber(string $adrNumber): static
    {
        $this->adrNumber = $adrNumber;

        return $this;
    }

    public function getAdrStreet(): ?string
    {
        return $this->adrStreet;
    }

    public function setAdrStreet(string $adrStreet): static
    {
        $this->adrStreet = $adrStreet;

        return $this;
    }

    public function getAdrZipCode(): ?string
    {
        return $this->adrZipCode;
    }

    public function setAdrZipCode(string $adrZipCode): static
    {
        $this->adrZipCode = $adrZipCode;

        return $this;
    }

    public function getAdrCity(): ?string
    {
        return $this->adrCity;
    }

    public function setAdrCity(string $adrCity): static
    {
        $this->adrCity = $adrCity;

        return $this;
    }

    public function getAdrAddInfo(): ?string
    {
        return $this->adrAddInfo;
    }

    public function setAdrAddInfo(?string $adrAddInfo): static
    {
        $this->adrAddInfo = $adrAddInfo;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(Users $user): static
    {
        $this->users->removeElement($user);

        return $this;
    }
}
