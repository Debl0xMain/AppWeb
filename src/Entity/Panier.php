<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PanierRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(operations: [
    new Get(),  
//    new Put(),
//    new Patch(),
//    new Delete(),
    new GetCollection(),
    new Post(),
],
normalizationContext: ['groups' => ['read']],
denormalizationContext: ['groups' => ['write']]
)]
#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $QuantityProduit = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $PriceUser = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    private ?Users $users = null;

    #[ORM\ManyToOne]
    private ?Product $products = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantityProduit(): ?int
    {
        return $this->QuantityProduit;
    }

    #[Groups(['write'])]
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

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    #[Groups(['write'])]
    public function setUsers(?Users $users): static
    {
        $this->users = $users;

        return $this;
    }

    public function getProducts(): ?Product
    {
        return $this->products;
    }

    public function setProducts(?Product $products): static
    {
        $this->products = $products;

        return $this;
    }

    public function __toString()
    {
        return $this->id;
    }

}
