<?php

namespace App\Repository;

use App\Entity\Hackathon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hackathon>
 */
class HackathonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hackathon::class);
    }

    /**
     * Charge un hackathon avec ses inscriptions, participants et équipes
     * en une seule requête (évite le problème N+1).
     */
    public function findWithInscriptions(int $id): ?Hackathon
    {
        return $this->createQueryBuilder('h')
            ->leftJoin('h.inscriptions', 'i')->addSelect('i')
            ->leftJoin('i.participant', 'p')->addSelect('p')
            ->leftJoin('i.equipe', 'e')->addSelect('e')
            ->leftJoin('i.equipeResponsable', 'er')->addSelect('er')
            ->where('h.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
