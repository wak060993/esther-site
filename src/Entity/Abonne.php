<?php

namespace App\Entity;

use App\Repository\AbonneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonneRepository::class)]
#[ORM\Table(name: 'abonne')]
class Abonne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private string $email = '';

    #[ORM\Column(name: 'date_inscription')]
    private \DateTimeImmutable $dateInscription;

    #[ORM\Column(length: 20)]
    private string $statut = 'actif';

    public function getId(): ?int { return $this->id; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }

    public function getDateInscription(): \DateTimeImmutable { return $this->dateInscription; }
    public function setDateInscription(\DateTimeImmutable $dateInscription): static { $this->dateInscription = $dateInscription; return $this; }

    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $statut): static { $this->statut = $statut; return $this; }
}