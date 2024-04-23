<?php

namespace App\Entity;

use App\Repository\SubCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(operations: [
    new Get(),  
    new GetCollection(),
],

normalizationContext: ['groups' => ['read']]
)]

#[ORM\Entity(repositoryClass: SubCategoryRepository::class)]
class SubCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['read'])]
    private ?string $subName = null;

    #[ORM\Column(length: 255)]
    private ?string $subPictureName = null;

    #[ORM\ManyToOne(inversedBy: 'subcategory')]
    private ?Category $categorys = null;
    #[Groups(['read'])]
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'subcategory')]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubName(): ?string
    {
        return $this->subName;
    }

    public function setSubName(string $subName): static
    {
        $this->subName = $subName;

        return $this;
    }

    public function getSubPictureName(): ?string
    {
        return $this->subPictureName;
    }

    public function setSubPictureName(string $subPictureName): static
    {
        $this->subPictureName = $subPictureName;

        return $this;
    }

    public function getCategorys(): ?Category
    {
        return $this->categorys;
    }

    public function setCategorys(?Category $categorys): static
    {
        $this->categorys = $categorys;

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
            $product->setSubcategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getSubcategory() === $this) {
                $product->setSubcategory(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->subName;
    }
}
