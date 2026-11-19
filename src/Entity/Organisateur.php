<?php

namespace App\Entity;

use App\Repository\OrganisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: OrganisateurRepository::class)]
class Organisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['hackathon:read'])]
    private ?int $id = null;


    #[ORM\Column(type: Types::STRING, length: 50)]
    #[Groups(['hackathon:read'])]
    private ?string $statut = null;

    #[ORM\Column(type: Types::STRING, length: 100)]
    #[Groups(['hackathon:read'])]
    private ?string $nom = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Groups(['hackathon:read'])]
    private ?string $siteweb = null;

    #[ORM\Column(type: Types::STRING, length: 150)]
    #[Groups(['hackathon:read'])]
    private ?string $email = null;

    /**
     * @var Collection<int, Hackathon>
     */
    #[ORM\OneToMany(targetEntity: Hackathon::class, mappedBy: 'organisateur')]
    private Collection $hackathons;

    public function __construct()
    {
        $this->hackathons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
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

    public function getSiteweb(): ?string
    {
        return $this->siteweb;
    }

    public function setSiteweb(?string $siteweb): static
    {
        $this->siteweb = $siteweb;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Hackathon>
     */
    public function getHackathons(): Collection
    {
        return $this->hackathons;
    }

    public function addHackathon(Hackathon $hackathon): static
    {
        if (!$this->hackathons->contains($hackathon)) {
            $this->hackathons->add($hackathon);
            $hackathon->setOrganisateur($this);
        }

        return $this;
    }

    public function removeHackathon(Hackathon $hackathon): static
    {
        if ($this->hackathons->removeElement($hackathon)) {
            // set the owning side to null (unless already changed)
            if ($hackathon->getOrganisateur() === $this) {
                $hackathon->setOrganisateur(null);
            }
        }

        return $this;
    }
}
