<?php

namespace App\Repository;

use App\Entity\UrlShortener;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UrlShortener|null find($id, $lockMode = null, $lockVersion = null)
 * @method UrlShortener|null findOneBy(array $criteria, array $orderBy = null)
 * @method UrlShortener[]    findAll()
 * @method UrlShortener[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlShortenerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UrlShortener::class);
    }

    // /**
    //  * @return UrlShortener[] Returns an array of UrlShortener objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UrlShortener
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
