<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LanguageRepository")
 */
class Language
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $iso;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $icon;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublish;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PictureCategory", mappedBy="languageAvailable")
     */
    private $pictureCategories;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PictureCategoryTranslation", mappedBy="languageAvailable")
     */
    private $pictureCategoryTranslations;

    public function __construct()
    {
        $this->pictureCategories = new ArrayCollection();
        $this->pictureCategoryTranslations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
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

    public function getIso(): ?string
    {
        return $this->iso;
    }

    public function setIso(string $iso): self
    {
        $this->iso = $iso;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIsPublish(): ?bool
    {
        return $this->isPublish;
    }

    public function setIsPublish(bool $isPublish): self
    {
        $this->isPublish = $isPublish;

        return $this;
    }

    /**
     * @return Collection|PictureCategory[]
     */
    public function getPictureCategories(): Collection
    {
        return $this->pictureCategories;
    }

    public function addPictureCategory(PictureCategory $pictureCategory): self
    {
        if (!$this->pictureCategories->contains($pictureCategory)) {
            $this->pictureCategories[] = $pictureCategory;
            $pictureCategory->addLanguageAvailable($this);
        }

        return $this;
    }

    public function removePictureCategory(PictureCategory $pictureCategory): self
    {
        if ($this->pictureCategories->contains($pictureCategory)) {
            $this->pictureCategories->removeElement($pictureCategory);
            $pictureCategory->removeLanguageAvailable($this);
        }

        return $this;
    }

    /**
     * @return Collection|PictureCategoryTranslation[]
     */
    public function getPictureCategoryTranslations(): Collection
    {
        return $this->pictureCategoryTranslations;
    }

    public function addPictureCategoryTranslation(PictureCategoryTranslation $pictureCategoryTranslation): self
    {
        if (!$this->pictureCategoryTranslations->contains($pictureCategoryTranslation)) {
            $this->pictureCategoryTranslations[] = $pictureCategoryTranslation;
            $pictureCategoryTranslation->addLanguageAvailable($this);
        }

        return $this;
    }

    public function removePictureCategoryTranslation(PictureCategoryTranslation $pictureCategoryTranslation): self
    {
        if ($this->pictureCategoryTranslations->contains($pictureCategoryTranslation)) {
            $this->pictureCategoryTranslations->removeElement($pictureCategoryTranslation);
            $pictureCategoryTranslation->removeLanguageAvailable($this);
        }

        return $this;
    }
}
