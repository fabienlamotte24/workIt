<?php

namespace App\Repository;

use App\Entity\PhaseClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhaseClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhaseClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhaseClient[]    findAll()
 * @method PhaseClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhaseClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhaseClient::class);
    }

    // /**
    //  * @return PhaseClient[] Returns an array of PhaseClient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PhaseClient
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
