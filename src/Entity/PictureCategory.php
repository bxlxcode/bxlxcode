<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureCategoryRepository")
 */
class PictureCategory
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Language", inversedBy="pictureCategories")
     * @Assert\NotBlank
     */
    private $languageAvailable;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Language", inversedBy="pictureCategories")
     */
    private $languageSource;

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
    private $isPublish;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PictureCategoryTranslation", mappedBy="pictureCategory")
     */
    private $pictureCategoryTranslations;

    public function __construct()
    {
        $this->languageAvailable = new ArrayCollection();
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

    public function getLanguageSource(): ?Language
    {
        return $this->languageSource;
    }

    public function setLanguageSource(?Language $languageSource): self
    {
        $this->languageSource = $languageSource;

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
            $pictureCategoryTranslation->addPictureCategory($this);
        }

        return $this;
    }

    public function removePictureCategoryTranslation(PictureCategoryTranslation $pictureCategoryTranslation): self
    {
        if ($this->pictureCategoryTranslations->contains($pictureCategoryTranslation)) {
            $this->pictureCategoryTranslations->removeElement($pictureCategoryTranslation);
            $pictureCategoryTranslation->removePictureCategory($this);
        }

        return $this;
    }
}
