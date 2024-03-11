<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $ordRef = null;

    #[ORM\Column(nullable: true)]
    private ?int $ordReduction = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2)]
    private ?string $ordClientCoefficient = null;

    #[ORM\Column(length: 255)]
    private ?string $ordAdressDelivery = null;

    #[ORM\Column(length: 255)]
    private ?string $ordAdressBilling = null;

    #[ORM\Column(length: 255)]
    private ?string $ordRebBill = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $ordDateBill = null;

    #[ORM\Column]
    private ?int $ordStatusBill = null;

    #[ORM\ManyToMany(targetEntity: ProductOrders::class, mappedBy: 'orders')]
    private Collection $productOrders;

    public function __construct()
    {
        $this->productOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrdRef(): ?int
    {
        return $this->ordRef;
    }

    public function setOrdRef(int $ordRef): static
    {
        $this->ordRef = $ordRef;

        return $this;
    }

    public function getOrdReduction(): ?int
    {
        return $this->ordReduction;
    }

    public function setOrdReduction(?int $ordReduction): static
    {
        $this->ordReduction = $ordReduction;

        return $this;
    }

    public function getOrdClientCoefficient(): ?string
    {
        return $this->ordClientCoefficient;
    }

    public function setOrdClientCoefficient(string $ordClientCoefficient): static
    {
        $this->ordClientCoefficient = $ordClientCoefficient;

        return $this;
    }

    public function getOrdAdressDelivery(): ?string
    {
        return $this->ordAdressDelivery;
    }

    public function setOrdAdressDelivery(string $ordAdressDelivery): static
    {
        $this->ordAdressDelivery = $ordAdressDelivery;

        return $this;
    }

    public function getOrdAdressBilling(): ?string
    {
        return $this->ordAdressBilling;
    }

    public function setOrdAdressBilling(string $ordAdressBilling): static
    {
        $this->ordAdressBilling = $ordAdressBilling;

        return $this;
    }

    public function getOrdRebBill(): ?string
    {
        return $this->ordRebBill;
    }

    public function setOrdRebBill(string $ordRebBill): static
    {
        $this->ordRebBill = $ordRebBill;

        return $this;
    }

    public function getOrdDateBill(): ?\DateTimeInterface
    {
        return $this->ordDateBill;
    }

    public function setOrdDateBill(\DateTimeInterface $ordDateBill): static
    {
        $this->ordDateBill = $ordDateBill;

        return $this;
    }

    public function getOrdStatusBill(): ?int
    {
        return $this->ordStatusBill;
    }

    public function setOrdStatusBill(int $ordStatusBill): static
    {
        $this->ordStatusBill = $ordStatusBill;

        return $this;
    }

    /**
     * @return Collection<int, ProductOrders>
     */
    public function getProductOrders(): Collection
    {
        return $this->productOrders;
    }

    public function addProductOrder(ProductOrders $productOrder): static
    {
        if (!$this->productOrders->contains($productOrder)) {
            $this->productOrders->add($productOrder);
            $productOrder->addOrder($this);
        }

        return $this;
    }

    public function removeProductOrder(ProductOrders $productOrder): static
    {
        if ($this->productOrders->removeElement($productOrder)) {
            $productOrder->removeOrder($this);
        }

        return $this;
    }
}
