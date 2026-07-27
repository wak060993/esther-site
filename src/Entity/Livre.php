<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
#[ORM\Table(name: 'livre')]
#[Vich\Uploadable]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private string $titre = '';

    #[ORM\Column(length: 180, unique: true)]
    private string $slug = '';

    #[ORM\Column(type: 'text')]
    private string $description = '';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $couverture = null;

    #[Vich\UploadableField(mapping: 'livres', fileNameProperty: 'couverture')]
    private ?File $couvertureFile = null;

    #[ORM\Column(name: 'lien_externe', length: 255)]
    private string $lienExterne = '';

    #[ORM\Column(name: 'ordre_affichage')]
    private int $ordreAffichage = 0;

    #[ORM\Column(name: 'date_publication', nullable: true)]
    private ?\DateTimeImmutable $datePublication = null;

    #[ORM\Column(name: 'updated_at', nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int { return $this->id; }

    public function getTitre(): string { return $this->titre; }
    public function setTitre(string $titre): static { $this->titre = $titre; return $this; }

    public function getSlug(): string { return $this->slug; }
    public function setSlug(string $slug): static { $this->slug = $slug; return $this; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): static { $this->description = $description; return $this; }

    public function getCouverture(): ?string { return $this->couverture; }
    public function setCouverture(?string $couverture): static { $this->couverture = $couverture; return $this; }

    public function getCouvertureFile(): ?File
    {
        return $this->couvertureFile;
    }

    public function setCouvertureFile(?File $couvertureFile = null): static
    {
        $this->couvertureFile = $couvertureFile;

        if (null !== $couvertureFile) {
            // force Doctrine à détecter le changement pour que Vich déclenche l'upload
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function getLienExterne(): string { return $this->lienExterne; }
    public function setLienExterne(string $lienExterne): static { $this->lienExterne = $lienExterne; return $this; }

    public function getOrdreAffichage(): int { return $this->ordreAffichage; }
    public function setOrdreAffichage(int $ordreAffichage): static { $this->ordreAffichage = $ordreAffichage; return $this; }

    public function getDatePublication(): ?\DateTimeImmutable { return $this->datePublication; }
    public function setDatePublication(?\DateTimeImmutable $datePublication): static { $this->datePublication = $datePublication; return $this; }

    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }
    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static { $this->updatedAt = $updatedAt; return $this; }
}