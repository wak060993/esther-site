<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name: 'article')]
#[Vich\Uploadable]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'articles')]
    #[ORM\JoinColumn(name: 'categorie_id', referencedColumnName: 'id', onDelete: 'SET NULL', nullable: true)]
    private ?Categorie $categorie = null;

    #[ORM\Column(length: 180)]
    private string $titre = '';

    #[ORM\Column(length: 180, unique: true)]
    private string $slug = '';

    #[ORM\Column(type: 'text')]
    private string $extrait = '';

    #[ORM\Column(type: 'text')]
    private string $contenu = '';

    #[ORM\Column(name: 'image_couverture', length: 255, nullable: true)]
    private ?string $imageCouverture = null;

    #[Vich\UploadableField(mapping: 'articles', fileNameProperty: 'imageCouverture')]
    private ?File $imageFile = null;

    #[ORM\Column(length: 20)]
    private string $statut = 'brouillon';

    #[ORM\Column(name: 'date_publication', nullable: true)]
    private ?\DateTimeImmutable $datePublication = null;

    #[ORM\Column(name: 'date_creation')]
    private \DateTimeImmutable $dateCreation;

    #[ORM\Column(name: 'date_modification', nullable: true)]
    private ?\DateTimeImmutable $dateModification = null;

    #[ORM\Column(name: 'updated_at', nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->dateCreation = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getCategorie(): ?Categorie { return $this->categorie; }
    public function setCategorie(?Categorie $categorie): static { $this->categorie = $categorie; return $this; }

    public function getTitre(): string { return $this->titre; }
    public function setTitre(string $titre): static { $this->titre = $titre; return $this; }

    public function getSlug(): string { return $this->slug; }
    public function setSlug(string $slug): static { $this->slug = $slug; return $this; }

    public function getExtrait(): string { return $this->extrait; }
    public function setExtrait(string $extrait): static { $this->extrait = $extrait; return $this; }

    public function getContenu(): string { return $this->contenu; }
    public function setContenu(string $contenu): static { $this->contenu = $contenu; return $this; }

    public function getImageCouverture(): ?string { return $this->imageCouverture; }
    public function setImageCouverture(?string $imageCouverture): static { $this->imageCouverture = $imageCouverture; return $this; }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): static
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $statut): static { $this->statut = $statut; return $this; }

    public function getDatePublication(): ?\DateTimeImmutable { return $this->datePublication; }
    public function setDatePublication(?\DateTimeImmutable $datePublication): static { $this->datePublication = $datePublication; return $this; }

    public function getDateCreation(): \DateTimeImmutable { return $this->dateCreation; }
    public function setDateCreation(\DateTimeImmutable $dateCreation): static { $this->dateCreation = $dateCreation; return $this; }

    public function getDateModification(): ?\DateTimeImmutable { return $this->dateModification; }
    public function setDateModification(?\DateTimeImmutable $dateModification): static { $this->dateModification = $dateModification; return $this; }

    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }
    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static { $this->updatedAt = $updatedAt; return $this; }
}