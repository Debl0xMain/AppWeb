<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?SubCategory $subcategory = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Supplier $suppliers = null;

    #[ORM\OneToMany(targetEntity: ProductDelivery::class, mappedBy: 'product')]
    private Collection $productDeliveries;

    #[ORM\OneToMany(targetEntity: ProductOrders::class, mappedBy: 'product')]
    private Collection $productOrders;

    public function __construct()
    {
        $this->productDeliveries = new ArrayCollection();
        $this->productOrders = new ArrayCollection();
    }

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

    public function getSubcategory(): ?SubCategory
    {
        return $this->subcategory;
    }

    public function setSubcategory(?SubCategory $subcategory): static
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    public function getSuppliers(): ?Supplier
    {
        return $this->suppliers;
    }

    public function setSuppliers(?Supplier $suppliers): static
    {
        $this->suppliers = $suppliers;

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
            $productDelivery->setProduct($this);
        }

        return $this;
    }

    public function removeProductDelivery(ProductDelivery $productDelivery): static
    {
        if ($this->productDeliveries->removeElement($productDelivery)) {
            // set the owning side to null (unless already changed)
            if ($productDelivery->getProduct() === $this) {
                $productDelivery->setProduct(null);
            }
        }

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
            $productOrder->setProduct($this);
        }

        return $this;
    }

    public function removeProductOrder(ProductOrders $productOrder): static
    {
        if ($this->productOrders->removeElement($productOrder)) {
            // set the owning side to null (unless already changed)
            if ($productOrder->getProduct() === $this) {
                $productOrder->setProduct(null);
            }
        }

        return $this;
    }
}
