<?php

namespace App\Entity;

use App\Repository\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupplierRepository::class)]
class Supplier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $supName = null;

    #[ORM\Column(length: 100)]
    private ?string $supRef = null;

    #[ORM\Column]
    private ?int $supType = null;

    #[ORM\Column(length: 15)]
    private ?string $supPhone = null;

    #[ORM\Column(length: 100)]
    private ?string $supMail = null;

    #[ORM\Column(length: 100)]
    private ?string $supAddress = null;

    #[ORM\Column]
    private ?int $supCodePostal = null;

    #[ORM\Column(length: 50)]
    private ?string $supNumberAddress = null;

    #[ORM\Column(length: 100)]
    private ?string $supVille = null;

    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'suppliers')]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSupName(): ?string
    {
        return $this->supName;
    }

    public function setSupName(string $supName): static
    {
        $this->supName = $supName;

        return $this;
    }

    public function getSupRef(): ?string
    {
        return $this->supRef;
    }

    public function setSupRef(string $supRef): static
    {
        $this->supRef = $supRef;

        return $this;
    }

    public function getSupType(): ?int
    {
        return $this->supType;
    }

    public function setSupType(int $supType): static
    {
        $this->supType = $supType;

        return $this;
    }

    public function getSupPhone(): ?string
    {
        return $this->supPhone;
    }

    public function setSupPhone(string $supPhone): static
    {
        $this->supPhone = $supPhone;

        return $this;
    }

    public function getSupMail(): ?string
    {
        return $this->supMail;
    }

    public function setSupMail(string $supMail): static
    {
        $this->supMail = $supMail;

        return $this;
    }

    public function getSupAddress(): ?string
    {
        return $this->supAddress;
    }

    public function setSupAddress(string $supAddress): static
    {
        $this->supAddress = $supAddress;

        return $this;
    }

    public function getSupCodePostal(): ?int
    {
        return $this->supCodePostal;
    }

    public function setSupCodePostal(int $supCodePostal): static
    {
        $this->supCodePostal = $supCodePostal;

        return $this;
    }

    public function getSupNumberAddress(): ?string
    {
        return $this->supNumberAddress;
    }

    public function setSupNumberAddress(string $supNumberAddress): static
    {
        $this->supNumberAddress = $supNumberAddress;

        return $this;
    }

    public function getSupVille(): ?string
    {
        return $this->supVille;
    }

    public function setSupVille(string $supVille): static
    {
        $this->supVille = $supVille;

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
            $product->setSuppliers($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getSuppliers() === $this) {
                $product->setSuppliers(null);
            }
        }

        return $this;
    }
}
