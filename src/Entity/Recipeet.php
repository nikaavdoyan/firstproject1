<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\Collection;
use App\Repository\RecipeetRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


#[ORM\Entity(repositoryClass: RecipeetRepository::class)]
#[UniqueEntity('name')]
#[ORM\HasLifecycleCallbacks]
class Recipeet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(
        min:2,
        max:50,
        minMessage:'Your name must be at least {{ limit }} characters long',
        maxMessage:'Your first name cannot be longer than {{ limit }} characters',
    )]
    private ?string $Name = null;

    #[ORM\Column]
    #[Assert\Length(1441)]
    private ?int $Time = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive()]
    #[Assert\LessThan(51)]
    private ?int $nbpeople = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive()]
    #[Assert\LessThan(6)]
    private ?int $difficulty = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive()]
    #[Assert\LessThan(1001)]
    private ?float $price = null;

    #[ORM\Column]
    private ?bool $isfavorite = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull()]
    private ?\DateTimeInterface $createdat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull()]
    private ?\DateTimeInterface $updatedate = null;

    #[ORM\ManyToMany(targetEntity:Ingredient::class)]
    private Collection $ingredients;

    public function __construct(
    )
    {
        $this->ingredients =new ArrayCollection();
        $this->createdat = new DateTimeImmutable();
        $this->updatedate = new DateTimeImmutable();

    }

    #[ORM\PrePersist]
    public function setUpdatedateValue(): void
    {
        $this->updatedate =new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->Time;
    }

    public function setTime(int $Time): static
    {
        $this->Time = $Time;

        return $this;
    }

    public function getNbpeople(): ?int
    {
        return $this->nbpeople;
    }

    public function setNbpeople(?int $nbpeople): static
    {
        $this->nbpeople = $nbpeople;

        return $this;
    }

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(?int $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getIsfavorite(): ?int
    {
        return $this->isfavorite;
    }

    public function setIsfavorite(int $isfavorite): static
    {
        $this->isfavorite = $isfavorite;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): static
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdatedate(): ?\DateTimeInterface
    {
        return $this->updatedate;
    }

    public function setUpdatedate(\DateTimeInterface $updatedate): static
    {
        $this->updatedate = $updatedate;

        return $this;
    }
    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }
    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)){
            $this->ingredients->add($ingredient);
        }
        return $this;

    }
    public function removeIngredient(Ingredient $ingredient): self
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }
}
