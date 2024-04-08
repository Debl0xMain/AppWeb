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
    private ?int $QuantityProduit = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $PriceUser = null;


    #[ORM\ManyToOne(inversedBy: 'paniers')]
    private ?Product $produit = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getProduit(): ?Product
    {
        return $this->produit;
    }

    public function setProduit(?Product $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

}
