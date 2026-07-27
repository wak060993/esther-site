<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ORM\Table(name: 'categorie')]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $nom = '';

    #[ORM\Column(length: 100, unique: true)]
    private string $slug = '';

    #[ORM\Column(name: 'couleur_accent', length: 20, nullable: true)]
    private ?string $couleurAccent = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Article::class)]
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): static { $this->nom = $nom; return $this; }

    public function getSlug(): string { return $this->slug; }
    public function setSlug(string $slug): static { $this->slug = $slug; return $this; }

    public function getCouleurAccent(): ?string { return $this->couleurAccent; }
    public function setCouleurAccent(?string $couleurAccent): static { $this->couleurAccent = $couleurAccent; return $this; }

    public function getArticles(): Collection { return $this->articles; }

    public function __toString(): string { return $this->nom; }
}