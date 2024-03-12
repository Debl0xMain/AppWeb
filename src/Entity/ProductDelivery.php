<?php

namespace App\Entity;

use App\Repository\ProductDeliveryRepository;
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

    #[ORM\ManyToOne(inversedBy: 'productDeliveries')]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'productDeliveries')]
    private ?Delivery $delivery = null;

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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    public function setDelivery(?Delivery $delivery): static
    {
        $this->delivery = $delivery;

        return $this;
    }
}
