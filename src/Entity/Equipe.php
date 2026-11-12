<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ObjectManager;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 100)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $lienPrototype = null;

    #[ORM\ManyToOne(inversedBy: 'equipes')]
    private ?Projet $projet = null;

    #[ORM\OneToOne(inversedBy: 'equipe', cascade: ['persist', 'remove'])]
    private ?Inscription $responsable = null;

    /**
     * @var Collection<int, Inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'equipe')]
    private Collection $regrouper;

    public function __construct()
    {
        $this->regrouper = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLienPrototype(): ?string
    {
        return $this->lienPrototype;
    }

    public function setLienPrototype(?string $lienPrototype): static
    {
        $this->lienPrototype = $lienPrototype;

        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): static
    {
        $this->projet = $projet;

        return $this;
    }

    public function getResponsable(): ?self
    {
        return $this->responsable;
    }

    public function setResponsable(?self $responsable): static
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getRegrouper(): Collection
    {
        return $this->regrouper;
    }

    public function addRegrouper(Inscription $regrouper): static
    {
        if (!$this->regrouper->contains($regrouper)) {
            $this->regrouper->add($regrouper);
            $regrouper->setEquipe($this);
        }

        return $this;
    }

    public function removeRegrouper(Inscription $regrouper): static
    {
        if ($this->regrouper->removeElement($regrouper)) {
            // set the owning side to null (unless already changed)
            if ($regrouper->getEquipe() === $this) {
                $regrouper->setEquipe(null);
            }
        }

        return $this;
    }


}
