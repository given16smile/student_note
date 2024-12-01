<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "Etudiant")]
class Etudiant
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 50)]
    private string $ETU;

    #[ORM\Column(type: "string", length: 100)]
    private string $nom;

    #[ORM\Column(type: "string", length: 50)]
    private string $prenom;

    #[ORM\Column(type: "date")]
    private \DateTime $naissance;

    // Getters and setters
    public function getETU(): string
    {
        return $this->ETU;
    }

    public function setETU(string $ETU): self
    {
        $this->ETU = $ETU;
        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getNaissance(): \DateTime
    {
        return $this->naissance;
    }

    public function setNaissance(\DateTime $naissance): self
    {
        $this->naissance = $naissance;
        return $this;
    }
}
