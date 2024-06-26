<?php

namespace App\Entity;

use App\Repository\ProductOrdersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductOrdersRepository::class)]
class ProductOrders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $pro_ordProductQuantity = null;

    #[ORM\Column(length: 255)]
    private ?string $pro_ordNameProduct = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 2)]
    private ?string $pro_ordPriceUht = null;

    #[ORM\ManyToOne(inversedBy: 'productOrders')]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'productOrders')]
    private ?Orders $orders = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $price_ligne = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $price_ligneht = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProOrdProductQuantity(): ?int
    {
        return $this->pro_ordProductQuantity;
    }

    public function setProOrdProductQuantity(int $pro_ordProductQuantity): static
    {
        $this->pro_ordProductQuantity = $pro_ordProductQuantity;

        return $this;
    }

    public function getProOrdNameProduct(): ?string
    {
        return $this->pro_ordNameProduct;
    }

    public function setProOrdNameProduct(string $pro_ordNameProduct): static
    {
        $this->pro_ordNameProduct = $pro_ordNameProduct;

        return $this;
    }
  
    public function getProOrdPriceUht(): ?string
    {
        return $this->pro_ordPriceUht;
    }

    public function setProOrdPriceUht(string $pro_ordPriceUht): static
    {
        $this->pro_ordPriceUht = $pro_ordPriceUht;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): static
    {
        $this->orders = $orders;

        return $this;
    }

    public function getPriceLigne(): ?string
    {
        return $this->price_ligne;
    }
//prix hors reduction prix base x coef client x tva
    public function setPriceLigne(?string $price_ligne): static
    {
        $this->price_ligne = $price_ligne;

        return $this;
    }
//prix hors reduction juste prix base x coef client
    public function getPriceLigneht(): ?string
    {
        return $this->price_ligneht;
    }

    public function setPriceLigneht(?string $price_ligneht): static
    {
        $this->price_ligneht = $price_ligneht;

        return $this;
    }
}
