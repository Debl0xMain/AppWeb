<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idProduit = null;

    #[ORM\Column]
    private ?int $QuantityProduit = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $PriceUser = null;

    #[ORM\OneToMany(targetEntity: Users::class, mappedBy: 'panier')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProduit(): ?int
    {
        return $this->idProduit;
    }

    public function setIdProduit(int $idProduit): static
    {
        $this->idProduit = $idProduit;

        return $this;
    }

    public function getQuantityProduit(): ?int
    {
        return $this->QuantityProduit;
    }

    public function setQuantityProduit(int $QuantityProduit): static
    {
        $this->QuantityProduit = $QuantityProduit;

        return $this;
    }

    public function getPriceUser(): ?string
    {
        return $this->PriceUser;
    }

    public function setPriceUser(string $PriceUser): static
    {
        $this->PriceUser = $PriceUser;

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
            $user->setPanier($this);
        }

        return $this;
    }

    public function removeUser(Users $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getPanier() === $this) {
                $user->setPanier(null);
            }
        }

        return $this;
    }
}
