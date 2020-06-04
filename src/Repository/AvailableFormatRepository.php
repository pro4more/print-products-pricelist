<?php

namespace App\Repository;

use App\Entity\AvailableFormat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AvailableFormat|null find($id, $lockMode = null, $lockVersion = null)
 * @method AvailableFormat|null findOneBy(array $criteria, array $orderBy = null)
 * @method AvailableFormat[]    findAll()
 * @method AvailableFormat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvailableFormatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AvailableFormat::class);
    }

    // /**
    //  * @return AvailableFormat[] Returns an array of AvailableFormat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AvailableFormat
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
