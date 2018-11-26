<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\ManyToMany(targetEntity="App\Entity\LanguageAvailable", inversedBy="categories")
     */
    private $languageAvailable;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LanguageSource", inversedBy="categories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $languageSource;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\CategoryTranslation", mappedBy="Category")
     */
    private $categoryTranslations;

    public function __construct()
    {
        $this->languageAvailable = new ArrayCollection();
        $this->categoryTranslations = new ArrayCollection();
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

    public function getLanguageSource(): ?LanguageSource
    {
        return $this->languageSource;
    }

    public function setLanguageSource(?LanguageSource $languageSource): self
    {
        $this->languageSource = $languageSource;

        return $this;
    }

    /**
     * @return Collection|CategoryTranslation[]
     */
    public function getCategoryTranslations(): Collection
    {
        return $this->categoryTranslations;
    }

    public function addCategoryTranslation(CategoryTranslation $categoryTranslation): self
    {
        if (!$this->categoryTranslations->contains($categoryTranslation)) {
            $this->categoryTranslations[] = $categoryTranslation;
            $categoryTranslation->addCategory($this);
        }

        return $this;
    }

    public function removeCategoryTranslation(CategoryTranslation $categoryTranslation): self
    {
        if ($this->categoryTranslations->contains($categoryTranslation)) {
            $this->categoryTranslations->removeElement($categoryTranslation);
            $categoryTranslation->removeCategory($this);
        }

        return $this;
    }
}
