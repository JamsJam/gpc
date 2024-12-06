<?php

namespace App\Entity;

use App\Repository\PromosRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromosRepository::class)]
class Promos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $beginAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\Column(length: 100)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $stripeLink1 = null;

    #[ORM\Column(length: 255)]
    private ?string $stripeLink2 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private array $pack1 = [];

    #[ORM\Column]
    private array $pack2 = [];

    #[ORM\Column]
    private ?int $prix1 = null;

    #[ORM\Column]
    private ?int $prix2 = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $crop = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeginAt(): ?\DateTimeImmutable
    {
        return $this->beginAt;
    }

    public function setBeginAt(\DateTimeImmutable $beginAt): static
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getStripeLink1(): ?string
    {
        return $this->stripeLink1;
    }

    public function setStripeLink1(string $stripeLink1): static
    {
        $this->stripeLink1 = $stripeLink1;

        return $this;
    }

    public function getStripeLink2(): ?string
    {
        return $this->stripeLink2;
    }

    public function setStripeLink2(string $stripeLink2): static
    {
        $this->stripeLink2 = $stripeLink2;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPack1(): array
    {
        return $this->pack1;
    }

    public function setPack1(array $pack1): static
    {
        $this->pack1 = $pack1;

        return $this;
    }

    public function getPack2(): array
    {
        return $this->pack2;
    }

    public function setPack2(array $pack2): static
    {
        $this->pack2 = $pack2;

        return $this;
    }

    public function getPrix1(): ?int
    {
        return $this->prix1;
    }

    public function setPrix1(int $prix1): static
    {
        $this->prix1 = $prix1;

        return $this;
    }

    public function getPrix2(): ?int
    {
        return $this->prix2;
    }

    public function setPrix2(int $prix2): static
    {
        $this->prix2 = $prix2;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }


    public function getCrop(): ?Array
    {
        return $this->crop;
    }

    public function setCrop(?Array $crop): self
    {
        $this->crop = $crop;

        return $this;
    }
}
