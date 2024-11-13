<?php

namespace App\Entity;

use App\Enum\EtatDemandeAdhesion;
use App\Repository\DemandeAdhesionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeAdhesionRepository::class)]
class DemandeAdhesion
{
    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable());
        $this->setEtat(EtatDemandeAdhesion::EN_ATTENTE);
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $raison_social = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $profession = null;

    #[ORM\Column(length: 255)]
    private ?string $contact = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: 'string', enumType: EtatDemandeAdhesion::class)]
    private ?EtatDemandeAdhesion $etat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPrenom(): ?string
    {
        return $this->nom_prenom;
    }

    public function setNomPrenom(string $nom_prenom): static
    {
        $this->nom_prenom = $nom_prenom;

        return $this;
    }

    public function getRaisonSocial(): ?string
    {
        return $this->raison_social;
    }

    public function setRaisonSocial(string $raison_social): static
    {
        $this->raison_social = $raison_social;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getEtat(): ?EtatDemandeAdhesion
    {
        return $this->etat;
    }

    public function setEtat(EtatDemandeAdhesion $etat): static
    {
        $this->etat = $etat;

        return $this;
    }
}
