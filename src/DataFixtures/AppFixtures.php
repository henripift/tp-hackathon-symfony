<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use App\Entity\Hackathon;
use App\Entity\Inscription;
use App\Entity\Organisateur;
use App\Entity\Participant;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Organisateurs

        for ($i = 0; $i < 3; $i++) {
            $orga = new Organisateur();
            $orga->setStatut("Statut $i");
            $orga->setNom("Organisateur $i");
            $orga->setSiteweb("https://organisateur$i.example");
            $orga->setEmail("organisateur$i@organisateur$i");
            $manager->persist($orga);

            $this->addReference("organisateur_".$i, $orga);
        }


        // Hackathons

        for ($i = 0; $i < 3; $i++) {
            $hack = new Hackathon();
            $hack->setDateHeureDebut(new \DateTimeImmutable('now'));
            $hack->setDateHeureFin(new \DateTimeImmutable('now'));
            $hack->setLieu("Lieu $i");
            $hack->setVille("Ville $i");
            $hack->setTheme("Theme $i");
            $orgaId = random_int(0, 2);
            $orga = $this->getReference('organisateur_'.$orgaId, Organisateur::class);

            $hack->setOrganisateur($orga);
            $this->addReference("hackathon_".$i, $hack);
            $manager->persist($hack);
        }

        // Projets

        for ($i = 0; $i < 3; $i++) {
            $projet = new Projet();
            $projet->setDescription("description projet $i");
            $projet->setRetenu("retenu projet $i");
            $hackId = random_int(0, 2);
            $hack = $this->getReference('hackathon_'.$hackId, Hackathon::class);
            $projet->setHackathon($hack);
        }

        // Participants
        for ($i = 0; $i < 3; $i++) {
            $participant = new Participant();
            $participant->setEmail("participant$i@participant$i");
            $participant->setNom("participant$i");
            $participant->setPrenom("participant$i");
            $participant->setTelephone("participant$i");
            $participant->setDateNaissance(new \DateTimeImmutable('now'));
            $participant->setLienPortefolio("participant$i");
        }
        // Inscriptions
        for ($i = 0; $i < 3; $i++) {
            $inscription = new Inscription();
            $inscription->setCompetence("competence $i");
            $inscription->setDate(new \DateTimeImmutable('now'));
            $hackId = random_int(0, 2);
            $hack = $this->getReference('hackathon_'.$hackId, Hackathon::class);
            $inscription->setHackathon($hack);
        }

        // Équipes
        $equipes = [
            ['Les Debuggers', 'https://github.com/example/debuggers'],
            ['Team Nantes', null],
            ['Null Pointers', 'https://github.com/example/null-pointers'],
        ];
        foreach ($equipes as [$nom, $prototype]) {
            $manager->persist((new Equipe())
                ->setNom($nom)
                ->setLienPrototype($prototype));
        }

        $manager->flush();
    }
}
