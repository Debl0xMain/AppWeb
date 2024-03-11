<?php

namespace App\Entity;

use App\Repository\ProductOrdersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 5)]
    private ?string $pro_ordPriceUht = null;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'productOrders')]
    private Collection $product;

    #[ORM\ManyToMany(targetEntity: Orders::class, inversedBy: 'productOrders')]
    private Collection $orders;

    public function __construct()
    {
        $this->product = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Product>
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->product->contains($product)) {
            $this->product->add($product);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        $this->product->removeElement($product);

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
        }

        return $this;
    }

    public function removeOrder(Orders $order): static
    {
        $this->orders->removeElement($order);

        return $this;
    }
}
