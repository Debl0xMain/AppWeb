<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $proName = null;

    #[ORM\Column(length: 255)]
    private ?string $proDesc = null;

    #[ORM\Column(length: 255)]
    private ?string $proPictureName = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2)]
    private ?string $proPriceHT = null;

    #[ORM\Column]
    private ?int $proActive = null;

    #[ORM\Column(length: 255)]
    private ?string $proRef = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProName(): ?string
    {
        return $this->proName;
    }

    public function setProName(string $proName): static
    {
        $this->proName = $proName;

        return $this;
    }

    public function getProDesc(): ?string
    {
        return $this->proDesc;
    }

    public function setProDesc(string $proDesc): static
    {
        $this->proDesc = $proDesc;

        return $this;
    }

    public function getProPictureName(): ?string
    {
        return $this->proPictureName;
    }

    public function setProPictureName(string $proPictureName): static
    {
        $this->proPictureName = $proPictureName;

        return $this;
    }

    public function getProPriceHT(): ?string
    {
        return $this->proPriceHT;
    }

    public function setProPriceHT(string $proPriceHT): static
    {
        $this->proPriceHT = $proPriceHT;

        return $this;
    }

    public function getProActive(): ?int
    {
        return $this->proActive;
    }

    public function setProActive(int $proActive): static
    {
        $this->proActive = $proActive;

        return $this;
    }

    public function getProRef(): ?string
    {
        return $this->proRef;
    }

    public function setProRef(string $proRef): static
    {
        $this->proRef = $proRef;

        return $this;
    }
}
