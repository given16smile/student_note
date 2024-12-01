<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Options;
use App\Entity\Semestre;

#[ORM\Entity]
#[ORM\Table(name: "Matieres")]
class Matieres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $idMatiere;

    #[ORM\Column(type: "string", length: 50, unique: true)]
    private string $code;

    #[ORM\Column(type: "string", length: 200)]
    private string $libelle;

    #[ORM\Column(type: "integer")]
    private int $credits;

    #[ORM\ManyToOne(targetEntity: Options::class)]
    #[ORM\JoinColumn(name: "idOptions", referencedColumnName: "idOptions", nullable: false)]
    private Options $option;

    #[ORM\ManyToOne(targetEntity: Semestre::class)]
    #[ORM\JoinColumn(name: "idSemestre", referencedColumnName: "idSemestre", nullable: false)]
    private Semestre $semestre;

    // Getters and setters
    public function getIdMatiere(): int
    {
        return $this->idMatiere;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function getCredits(): int
    {
        return $this->credits;
    }

    public function setCredits(int $credits): self
    {
        $this->credits = $credits;
        return $this;
    }

    public function getOption(): Options
    {
        return $this->option;
    }

    public function setOption(Options $option): self
    {
        $this->option = $option;
        return $this;
    }

    public function getSemestre(): Semestre
    {
        return $this->semestre;
    }

    public function setSemestre(Semestre $semestre): self
    {
        $this->semestre = $semestre;
        return $this;
    }
}
