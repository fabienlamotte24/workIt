<?php

namespace App\Repository;

use App\Entity\TemplateEmail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TemplateEmail|null find($id, $lockMode = null, $lockVersion = null)
 * @method TemplateEmail|null findOneBy(array $criteria, array $orderBy = null)
 * @method TemplateEmail[]    findAll()
 * @method TemplateEmail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemplateEmailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TemplateEmail::class);
    }

    // /**
    //  * @return TemplateEmail[] Returns an array of TemplateEmail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TemplateEmail
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
