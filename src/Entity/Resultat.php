<?php
namespace App\Entity;
class Resultat
{
    private string $etu;
    private string $code;
    private string $matiere;
    private int $credit;
    private float $notes;
    private \DateTimeInterface $dateSession;

    public function getEtu(): string
    {
        return $this->etu;
    }

    public function setEtu(string $etu): self
    {
        $this->etu = $etu;
        return $this;
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

    public function getMatiere(): string
    {
        return $this->matiere;
    }

    public function setMatiere(string $matiere): self
    {
        $this->matiere = $matiere;
        return $this;
    }

    public function getCredit(): int
    {
        return $this->credit;
    }

    public function setCredit(int $credit): self
    {
        $this->credit = $credit;
        return $this;
    }

    public function getNotes(): float
    {
        return $this->notes;
    }

    public function setNotes(float $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function getDateSession(): \DateTimeInterface
    {
        return $this->dateSession;
    }

    public function setDateSession(\DateTimeInterface $dateSession): self
    {
        $this->dateSession = $dateSession;
        return $this;
    }
}
