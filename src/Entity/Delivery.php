<?php

namespace App\Entity;

use App\Repository\DeliveryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeliveryRepository::class)]
class Delivery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $delDateExped = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $delDatePlannedDelivery = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $delDateDeliveryClient = null;

    #[ORM\ManyToMany(targetEntity: ProductDelivery::class, inversedBy: 'deliveries')]
    private Collection $product;

    public function __construct()
    {
        $this->product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDelDateExped(): ?\DateTimeInterface
    {
        return $this->delDateExped;
    }

    public function setDelDateExped(?\DateTimeInterface $delDateExped): static
    {
        $this->delDateExped = $delDateExped;

        return $this;
    }

    public function getDelDatePlannedDelivery(): ?\DateTimeInterface
    {
        return $this->delDatePlannedDelivery;
    }

    public function setDelDatePlannedDelivery(?\DateTimeInterface $delDatePlannedDelivery): static
    {
        $this->delDatePlannedDelivery = $delDatePlannedDelivery;

        return $this;
    }

    public function getDelDateDeliveryClient(): ?\DateTimeInterface
    {
        return $this->delDateDeliveryClient;
    }

    public function setDelDateDeliveryClient(?\DateTimeInterface $delDateDeliveryClient): static
    {
        $this->delDateDeliveryClient = $delDateDeliveryClient;

        return $this;
    }

    /**
     * @return Collection<int, ProductDelivery>
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(ProductDelivery $product): static
    {
        if (!$this->product->contains($product)) {
            $this->product->add($product);
        }

        return $this;
    }

    public function removeProduct(ProductDelivery $product): static
    {
        $this->product->removeElement($product);

        return $this;
    }
}
