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

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $delDateExped = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $delDatePlannedDelivery = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $delDateDeliveryClient = null;

    #[ORM\ManyToOne(inversedBy: 'deliveries')]
    private ?Orders $orders = null;

    #[ORM\OneToMany(targetEntity: ProductDelivery::class, mappedBy: 'delivery')]
    private Collection $productDeliveries;

    public function __construct()
    {
        $this->productDeliveries = new ArrayCollection();
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

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): static
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * @return Collection<int, ProductDelivery>
     */
    public function getProductDeliveries(): Collection
    {
        return $this->productDeliveries;
    }

    public function addProductDelivery(ProductDelivery $productDelivery): static
    {
        if (!$this->productDeliveries->contains($productDelivery)) {
            $this->productDeliveries->add($productDelivery);
            $productDelivery->setDelivery($this);
        }

        return $this;
    }

    public function removeProductDelivery(ProductDelivery $productDelivery): static
    {
        if ($this->productDeliveries->removeElement($productDelivery)) {
            // set the owning side to null (unless already changed)
            if ($productDelivery->getDelivery() === $this) {
                $productDelivery->setDelivery(null);
            }
        }

        return $this;
    }
}
