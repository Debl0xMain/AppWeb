<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(operations: [
    new Get(),  
    new GetCollection(),
],

normalizationContext: ['groups' => ['read']]
)]

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['read'])]
    private ?string $catName = null;

    #[ORM\Column(length: 255)]
    private ?string $catPictureName = null;

    #[Groups(['read'])]
    #[ORM\OneToMany(targetEntity: SubCategory::class, mappedBy: 'categorys')]
    private Collection $subcategory;

    public function __construct()
    {
        $this->subcategory = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCatName(): ?string
    {
        return $this->catName;
    }

    public function setCatName(string $catName): static
    {
        $this->catName = $catName;

        return $this;
    }

    public function getCatPictureName(): ?string
    {
        return $this->catPictureName;
    }

    public function setCatPictureName(string $catPictureName): static
    {
        $this->catPictureName = $catPictureName;

        return $this;
    }

    /**
     * @return Collection<int, SubCategory>
     */
    public function getSubcategory(): Collection
    {
        return $this->subcategory;
    }

    public function addSubcategory(SubCategory $subcategory): static
    {
        if (!$this->subcategory->contains($subcategory)) {
            $this->subcategory->add($subcategory);
            $subcategory->setCategorys($this);
        }

        return $this;
    }

    public function removeSubcategory(SubCategory $subcategory): static
    {
        if ($this->subcategory->removeElement($subcategory)) {
            // set the owning side to null (unless already changed)
            if ($subcategory->getCategorys() === $this) {
                $subcategory->setCategorys(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->catName;
    }
}
