<?php
namespace App\Repository;

use App\Entity\OffreStage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OffreStage>
 */
class OffreStageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OffreStage::class);
    }

    public function findValidatedOffers(): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.validee = :val')
            ->setParameter('val', true)
            ->getQuery()
            ->getResult();
    }
}