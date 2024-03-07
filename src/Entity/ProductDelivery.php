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
}
