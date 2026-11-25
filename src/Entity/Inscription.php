<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $num = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(type: Types::STRING, length: 100)]
    private ?string $competence = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Hackathon $hackathon = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    private ?Participant $participant = null;

    // Équipe dont l'inscrit est membre (liée à Equipe::$regrouper)
    #[ORM\ManyToOne(inversedBy: 'regrouper')]
    private ?Equipe $equipe = null;

    // Équipe dont l'inscrit est le responsable (liée à Equipe::$responsable)
    #[ORM\OneToOne(mappedBy: 'responsable')]
    private ?Equipe $equipeResponsable = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): static
    {
        $this->num = $num;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getCompetence(): ?string
    {
        return $this->competence;
    }

    public function setCompetence(string $competence): static
    {
        $this->competence = $competence;

        return $this;
    }

    public function getHackathon(): ?Hackathon
    {
        return $this->hackathon;
    }

    public function setHackathon(?Hackathon $hackathon): static
    {
        $this->hackathon = $hackathon;

        return $this;
    }

    public function getParticipant(): ?Participant
    {
        return $this->participant;
    }

    public function setParticipant(?Participant $participant): static
    {
        $this->participant = $participant;

        return $this;
    }

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): static
    {
        $this->equipe = $equipe;

        return $this;
    }

    public function getEquipeResponsable(): ?Equipe
    {
        return $this->equipeResponsable;
    }

    public function setEquipeResponsable(?Equipe $equipe): static
    {
        // unset the owning side of the relation if necessary
        if ($equipe === null && $this->equipeResponsable !== null) {
            $this->equipeResponsable->setResponsable(null);
        }

        // set the owning side of the relation if necessary
        if ($equipe !== null && $equipe->getResponsable() !== $this) {
            $equipe->setResponsable($this);
        }

        $this->equipeResponsable = $equipe;

        return $this;
    }
}
