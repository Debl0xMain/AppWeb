<?php

namespace App\Entity;

use App\Repository\SubCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubCategoryRepository::class)]
class SubCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $subName = null;

    #[ORM\Column(length: 255)]
    private ?string $subPictureName = null;

    #[ORM\ManyToOne(inversedBy: 'subcategory')]
    private ?Category $categorys = null;

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
}
