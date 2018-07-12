<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass()
 */
class TermParent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner le nom du terme.")
     * @Assert\Length(min=2, max=255, minMessage="2 caractères minimum", maxMessage="255 caractères maximum")
     * @ORM\Column(type="string", length=255)
     */
    private $term;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner l'identifiant du terme.")
     * @Assert\Length(min=3, max=255, minMessage="3 caractères minimum", maxMessage="255 caractères maximum")
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner une définition pour ce terme.")
     * @Assert\Length(min=10, max=1000, minMessage="10 caractères minimum", maxMessage="1000 caractères maximum")
     * @ORM\Column(type="text")
     */
    private $definition1;

    /**
     * @Assert\Length(max=255, maxMessage="1000 caractères maximum")
     * @ORM\Column(type="text", nullable=true)
     */
    private $definition2;

    /**
     * @Assert\Length(max=255, maxMessage="1000 caractères maximum")
     * @ORM\Column(type="text", nullable=true)
     */
    private $example;

    /**
     * @Assert\Length(max=255, maxMessage="1000 caractères maximum")
     * @ORM\Column(type="text", nullable=true)
     */
    private $translation;

    /**
     * @Assert\Length(max=255, maxMessage="1000 caractères maximum")
     * @ORM\Column(type="text", nullable=true)
     */
    private $variations;

    /**
     * @Assert\Length(max=255, maxMessage="1000 caractères maximum")
     * @ORM\Column(type="text", nullable=true)
     */
    private $pronunciation;

    /**
     * @Assert\Length(max=255, maxMessage="1000 caractères maximum")
     * @ORM\Column(type="text", nullable=true)
     */
    private $origin;

    /**
     * @ORM\Column(type="integer")
     */
    private $createdDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $editedDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $votesCount;

    /**
     * @Assert\NotBlank(message="Veuillez choisir une catégorie.")
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="terms")
     */
    private $categorie;




    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTerm(): ?string
    {
        return $this->term;
    }

    public function setTerm(string $term): self
    {
        $this->term = $term;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDefinition1(): ?string
    {
        return $this->definition1;
    }

    public function setDefinition1(string $definition1): self
    {
        $this->definition1 = $definition1;

        return $this;
    }

    public function getDefinition2(): ?string
    {
        return $this->definition2;
    }

    public function setDefinition2(?string $definition2): self
    {
        $this->definition2 = $definition2;

        return $this;
    }

    public function getExample(): ?string
    {
        return $this->example;
    }

    public function setExample(?string $example): self
    {
        $this->example = $example;

        return $this;
    }

    public function getTranslation(): ?string
    {
        return $this->translation;
    }

    public function setTranslation(?string $translation): self
    {
        $this->translation = $translation;

        return $this;
    }

    public function getVariations(): ?string
    {
        return $this->variations;
    }

    public function setVariations(?string $variations): self
    {
        $this->variations = $variations;

        return $this;
    }

    public function getPronunciation(): ?string
    {
        return $this->pronunciation;
    }

    public function setPronunciation(?string $pronunciation): self
    {
        $this->pronunciation = $pronunciation;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(?string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getCreatedDate(): ?int
    {
        return $this->createdDate;
    }

    public function setCreatedDate(int $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getEditedDate(): ?int
    {
        return $this->editedDate;
    }

    public function setEditedDate(?int $editedDate): self
    {
        $this->editedDate = $editedDate;

        return $this;
    }

    public function getVotesCount(): ?int
    {
        return $this->votesCount;
    }

    public function setVotesCount(int $votesCount): self
    {
        $this->votesCount = $votesCount;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }



}
