<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryTranslationRepository")
 */
class CategoryTranslation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\LanguageAvailable", inversedBy="categoryTranslations")
     */
    private $languageAvailable;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="categoryTranslations")
     */
    private $Category;

    public function __construct()
    {
        $this->languageAvailable = new ArrayCollection();
        $this->Category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|LanguageAvailable[]
     */
    public function getLanguageAvailable(): Collection
    {
        return $this->languageAvailable;
    }

    public function addLanguageAvailable(LanguageAvailable $languageAvailable): self
    {
        if (!$this->languageAvailable->contains($languageAvailable)) {
            $this->languageAvailable[] = $languageAvailable;
        }

        return $this;
    }

    public function removeLanguageAvailable(LanguageAvailable $languageAvailable): self
    {
        if ($this->languageAvailable->contains($languageAvailable)) {
            $this->languageAvailable->removeElement($languageAvailable);
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategory(): Collection
    {
        return $this->Category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->Category->contains($category)) {
            $this->Category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->Category->contains($category)) {
            $this->Category->removeElement($category);
        }

        return $this;
    }
}
