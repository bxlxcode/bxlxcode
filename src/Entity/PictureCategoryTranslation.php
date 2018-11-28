<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureCategoryTranslationRepository")
 */
class PictureCategoryTranslation
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Language", inversedBy="pictureCategoryTranslations")
     */
    private $languageAvailable;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PictureCategory", inversedBy="pictureCategoryTranslations")
     */
    private $pictureCategory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isTranslated;

    public function __construct()
    {
        $this->languageAvailable = new ArrayCollection();
        $this->pictureCategory = new ArrayCollection();
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

    /**
     * @return Collection|Language[]
     */
    public function getLanguageAvailable(): Collection
    {
        return $this->languageAvailable;
    }

    public function addLanguageAvailable(Language $languageAvailable): self
    {
        if (!$this->languageAvailable->contains($languageAvailable)) {
            $this->languageAvailable[] = $languageAvailable;
        }

        return $this;
    }

    public function removeLanguageAvailable(Language $languageAvailable): self
    {
        if ($this->languageAvailable->contains($languageAvailable)) {
            $this->languageAvailable->removeElement($languageAvailable);
        }

        return $this;
    }

    /**
     * @return Collection|PictureCategory[]
     */
    public function getPictureCategory(): Collection
    {
        return $this->pictureCategory;
    }

    public function addPictureCategory(PictureCategory $pictureCategory): self
    {
        if (!$this->pictureCategory->contains($pictureCategory)) {
            $this->pictureCategory[] = $pictureCategory;
        }

        return $this;
    }

    public function removePictureCategory(PictureCategory $pictureCategory): self
    {
        if ($this->pictureCategory->contains($pictureCategory)) {
            $this->pictureCategory->removeElement($pictureCategory);
        }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsTranslated(): ?bool
    {
        return $this->isTranslated;
    }

    public function setIsTranslated(bool $isTranslated): self
    {
        $this->isTranslated = $isTranslated;

        return $this;
    }
}
