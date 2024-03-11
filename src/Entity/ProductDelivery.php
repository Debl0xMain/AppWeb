<?php

namespace App\Entity;

use App\Repository\ProductDeliveryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductDeliveryRepository::class)]
class ProductDelivery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $pro_delProductQuantity = null;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'delivery')]
    private Collection $products;

    #[ORM\ManyToMany(targetEntity: Delivery::class, mappedBy: 'product')]
    private Collection $deliveries;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->deliveries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProDelProductQuantity(): ?int
    {
        return $this->pro_delProductQuantity;
    }

    public function setProDelProductQuantity(int $pro_delProductQuantity): static
    {
        $this->pro_delProductQuantity = $pro_delProductQuantity;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->addDelivery($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            $product->removeDelivery($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Delivery>
     */
    public function getDeliveries(): Collection
    {
        return $this->deliveries;
    }

    public function addDelivery(Delivery $delivery): static
    {
        if (!$this->deliveries->contains($delivery)) {
            $this->deliveries->add($delivery);
            $delivery->addProduct($this);
        }

        return $this;
    }

    public function removeDelivery(Delivery $delivery): static
    {
        if ($this->deliveries->removeElement($delivery)) {
            $delivery->removeProduct($this);
        }

        return $this;
    }
}
