<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $catName = null;

    #[ORM\Column(length: 255)]
    private ?string $catPictureName = null;

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
}
